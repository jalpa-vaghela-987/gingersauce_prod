<?php

namespace App\Jobs;

use App\Brandbook;
use App\Mail\BrandbookIsReady;
use App\Theme;
use Color\System\Enum\PANTONE as PANTONEEnum;
use Color\System\PANTONE as PANTONESystem;
use Color\Value\HEX as HEXValue;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\ImageManagerStatic as Image;
use PDF;


class GeneratePDF implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $brandBookId;
    public $bb;
    public $hasAll;
    public $theme;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($brandBookId, $bb, $hasAll, $theme=null)
    {
        $this->brandBookId = $brandBookId;
        $this->bb = $bb;
        $this->hasAll = $hasAll;
        $this->theme = $theme;
    }

    /**
     * Execute the job.
     *
     * @return voidknpsnappy
     */
    public function handle()
    {
        if($this->bb->bb_version == 1) {
            if ($this->hasAll) {
                $themes = Theme::where('is_active', true)->orderBy('name','desc')->get();
                $pdfs = [];
                foreach ($themes as $theme) {
                    $pdfs[$theme->id] = $this->pdf_prepare($this->brandBookId, $theme->id, false, true);
                }
                Brandbook::where('id', $this->bb->id)->update(['pdf_link' => json_encode($pdfs)]);

                Mail::to($this->bb->user->email)
                    ->bcc(config('mail.bcc'))
                    ->send((new BrandbookIsReady($this->bb)));
            }else{
                $this->pdf_prepare( $this->brandBookId, $this->theme );
            }
        } else {
            Mail::to($this->bb->user->email)
                ->bcc(config('mail.bcc'))
                ->send((new BrandbookIsReady($this->bb)));
        }
    }

    public function pdf_prepare($id, $theme, $spreads = false, $add_theme_to_pdf = false)
    {
        $bb = Brandbook::findOrFail($id);
        if($bb->bb_version == 1) {
            $theme_id = $theme;
            if (empty($theme))
                $theme = 'gradient';

            if (intval($theme) == 0 && $theme == $bb->theme) {
                $t = Theme::where('name', $theme)->first();
                $theme_id = $t->id;
                $theme = json_decode($t->file, true);
                $theme = $theme[0]['download_link'];
            } else {

                $t = Theme::find($theme);

                if (!$t) {
                    $t = Theme::active()->first();
                }

                $theme_id = $t->id;
                $theme = json_decode($t->file, true);
                $theme = $theme[0]['download_link'];
            }

            copy(storage_path('app/public/' . $theme), resource_path('views') . '/themes/' . str_replace('.php', '.blade.php', basename($theme)));

            if ($spreads) {
                $html = file_get_contents(resource_path('views') . '/themes/' . str_replace('.php', '.blade.php', basename($theme)));
                $html .= '<style>div[id^="page"]{float: left;}
            .page-break{
                page-break-after: unset !important;
            }
            .pb1, .pb3, .pb5, .pb7, .pb9, .pb11, .pb13, .pb15, .pb17, .pb19, .pb21, .pb23, .pb25, .pb27, .pb29, .pb31, .pb33, .pb35{
                page-break-after: always !important;
                clear: both !important;
                float: none !important;

        }
            div[id^="page"]:nth-child(2n){page-break-after: always;}#page1{float: right; clear: both}</style>';
                file_put_contents(resource_path('views') . '/themes/' . str_replace('.php', '.blade.php', basename($theme)), $html);
            }

            $theme = 'themes.' . str_replace('.php', '', basename($theme));

            $bb->colors_list = collect(json_decode($bb->colors_list))/*)*/ ->map(function ($color, $index) {
                if (!isset($color->show_shades))
                    $color->show_shades = true;

                if (!isset($color->color)) {
                    return $color;
                }
                if (isset($color->color->loaded) && $color->color->loaded == false) {
                    $data = json_decode(file_get_contents("http://www.thecolorapi.com/id?format=json&hex=" . str_replace('#', '', $color->color->hex->value)));
                    $data->loaded = true;
                    $color->color = $data;
                }
                $color->color->scheme = json_decode(file_get_contents('http://www.thecolorapi.com/scheme?format=json&named=false&hex=' . str_replace('#', '', $color->color->hex->value) . '&count=5'));
                $hex = new HEXValue(str_replace('#', '', $color->color->hex->value));
                $pantoneSolidCoated = new PANTONESystem(
                    PANTONEEnum::PANTONE_PLUS_SOLID_COATED()
                );
                try {
                    $pantone = $pantoneSolidCoated->findColor($hex, 15);
                    $color->pantone = $pantone->getIterator()->current();
                } catch (InvalidInputNumberException $e) {
                    $color->pantone = '';
                }
                return $color;
            })->all();

            $bb->approved = json_decode($bb->approved);
            $bb->rejected = json_decode($bb->rejected);

            $bb->approved_icon = json_decode($bb->approved_icon, true);
            if (!is_array($bb->approved_icon))
                $bb->approved_icon = [];

            if (!is_array($bb->core_values))
                $bb->core_values = json_decode($bb->core_values, true);

            if (!is_array($bb->core_values) || $bb->core_values == null)
                $bb->core_values = [];

            $bb->logo_versions = json_decode($bb->logo_versions);
            $bb->missuses = json_decode($bb->missuses);
            $bb->mockups = json_decode($bb->mockups);
            $bb->icon_family = json_decode($bb->icon_family, true);
            $if = [];
            if (is_array($bb->icon_family))
                foreach ($bb->icon_family as $i => $item) {
                    $item['icon_b64'] = base64_encode(file_get_contents(storage_path('app/' . $item['icon'])));
                    $if[$i] = $item;
                }
            $bb->icon_family = $if;

            if (!is_array($bb->logo_versions))
                $bb->logo_versions = [];
            if (!is_array($bb->missuses))
                $bb->missuses = [];
            if (!is_array($bb->mockups))
                $bb->mockups = [];
            if (!is_array($bb->approved))
                $bb->approved = [];

            $bb->fonts_main = collect(json_decode($bb->fonts_main, true));
            $bb->fonts_main = $bb->fonts_main->map(function ($item) {

                if (isset($item['file'])) {
                    $path = str_replace('/storage', '/public', $item['file']);
                    if (strpos($item['file'], 'fonts.gstatic.com') == false)
                        $data = file_get_contents(public_path() . $item['file']);
                    else
                        $data = file_get_contents($item['file']);
                    $item['font'] = 'data:font/truetype;charset=utf-8;base64,' . base64_encode($data);
                    return $item;
                }
            });

            $bb->fonts_secondary = collect(json_decode($bb->fonts_secondary, true));
            $bb->fonts_secondary = $bb->fonts_secondary->map(function ($item) {

                if (isset($item['file'])) {
                    $path = str_replace('/storage', '/public', $item['file']);
                    if (strpos($item['file'], 'fonts.gstatic.com') == false)
                        $data = file_get_contents(public_path() . $item['file']);
                    else
                        $data = file_get_contents($item['file']);
                    $item['font'] = 'data:font/truetype;charset=utf-8;base64,' . base64_encode($data);
                    return $item;
                }
            });

            $icon = $this->getImageDimensions($bb->icon);
            $logo_d = $this->getImageDimensions($bb->logo);

            $bb->logo_w = $logo_d['w'];
            $bb->logo_h = $logo_d['h'];

            $all_logos = [];
            $all_icons = [];
            if (!empty($bb->all_logo_variations)) {
                foreach (json_decode($bb->all_logo_variations, true) as $all_logo_variation) {
                    $all_logos[$all_logo_variation['id']] = $all_logo_variation;
                }
            }

            if (!empty($bb->all_icon_variations)) {
                foreach (json_decode($bb->all_icon_variations, true) as $all_icon_variation) {
                    $all_icons[$all_icon_variation['id']] = $all_icon_variation;
                }
            }

            $bb->all_icon_variations = $all_icons;
            $bb->all_logo_variations = $all_logos;

            try {
                $ext = pathinfo($bb->user->avatar, PATHINFO_EXTENSION);
                if (strpos($bb->user->avatar, 'http') === false) {
                    $bb->user->avatar = "data:image/{$ext};base64," . base64_encode(\File::get(public_path($bb->user->avatar)));
                } else {
                    $bb->user->avatar = $bb->user->avatar;
                }

            } catch (\Exception $e) {
                info('Avatar not found at path' . $bb->user->avatar);
                $bb->user->avatar = "data:image/png;base64," . base64_encode(\File::get(public_path('users/default.png')));
            }

            if ($spreads) {
                $pdf = PDF::loadView($theme, [
                    'data' => $bb, 'icon_w' => $icon['w'],
                    'icon_h' => $icon['h'],
                    'watermark'=>"data:image/png;base64," . base64_encode(\File::get( public_path( 'img/watermark-draft.png' )))
                ])->setOption('enable-local-file-access', true)
                    ->setOption('page-width', '1168px')
                    ->setOption('page-height', '584px')/*->setOption('no-outline', true)*/
                    ->setOption('margin-top', 0)
                    ->setOption('margin-bottom', 0)
                    ->setOption('margin-left', 0)
                    ->setOption('margin-right', 0);
                //->setOption('lowquality', 1);//setOptions(['dpi'=>300])->setPaper([0,0,840,840])->
                $file = '/storage/user_files/' . $bb->user->id . '/' . time() . '-spread.pdf';
                $pdf->setOption('encoding', 'utf-8');
                $pdf->save(public_path() . $file);
                return $pdf->download(basename($file));//download
            } else {
                $pdf = PDF::loadView($theme, [
                    'data' => $bb, 'icon_w' => $icon['w'],
                    'icon_h' => $icon['h'],
                    'watermark'=>"data:image/png;base64," . base64_encode(\File::get( public_path( 'img/watermark-draft.png' )))
                ])->setOption('enable-local-file-access', true)
                    ->setOption('page-width', '560px')
                    ->setOption('page-height', '560px')/*->setOption('no-outline', true)*/
                    ->setOption('margin-top', 0)
                    ->setOption('margin-bottom', 0)
                    ->setOption('margin-left', 0)
                    ->setOption('margin-right', 0);//->setOption('lowquality', 1);//setOptions(['dpi'=>300])->setPaper([0,0,840,840])->
                $file = '/storage/user_files/' . $bb->user->id . '/' . $theme_id . '-' . time() . '.pdf';
                $pdf->setOption('encoding', 'utf-8');
                $pdf->save(public_path() . $file);
            }

            unset($bb->icon_w);
            unset($bb->icon_h);

            Brandbook::where('id', $bb->id)->update(['pdf_link' => json_encode([$bb->theme => $file])]);
            if ($spreads) {
                return $pdf->inline($bb->id . '.pdf');
            } else {
                return $file;
            }
        } else {
            return "";
        }
    }

    public function getImageDimensions($image)
    {
        if (!empty($image) && $image != 'skipped' && $image != '[]') {

            if ($size = $this->getSvgSize($image)) {
                return ['w' => $size['width'], 'h' => $size['height']];
            }

            $fn = storage_path(time() . uniqid() . '.svg');
            file_put_contents($fn, $image);
            Image::configure(['driver' => 'imagick']);
            $img = Image::make($fn);
            $w = $img->width();
            $h = $img->height();
            unlink($fn);
            return ['w' => $w, 'h' => $h];
        } else {
            return ['w' => 50, 'h' => 50];
        }
    }

    public function getSvgSize($image)
    {
        try {
            $dom = new \DOMDocument('1.0', 'utf-8');
            $dom->loadXML($image);
            $svg = $dom->documentElement;

            foreach ($svg->attributes as $attr) {
                $attributes[$attr->nodeName] = $attr->nodeValue;
            }

            if (isset($attributes['height']) and isset($attributes['width'])) {
                return ['width' => intval($attributes['width']), 'height' => intval($attributes['height'])];
            }
            return false;

        } catch (\Exception $exception) {
            return false;
        }

    }
}
