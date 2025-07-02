<?php

namespace App\Http\Controllers;

use App\Traits\ImageTrait;
use App\User;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Mail\BrandbookIsReady;
use Auth;
use PDF;
use App\Share;
use App\Brandbook;
use App\Theme;
use Mail;
use Illuminate\Support\Facades\Storage;
use Color\Value\HEX as HEXValue;
use Color\System\PANTONE as PANTONESystem;
use Color\System\Enum\PANTONE as PANTONEEnum;
use Intervention\Image\ImageManagerStatic as Image;
use View;
use Symfony\Component\Process\Process;
use Carbon\Carbon;
use const http\Client\Curl\AUTH_ANY;


class BrandbookController extends Controller {

    use ImageTrait;

    public function my( Request $request ) {

        if ( Auth::check() && Auth::user()->can_create_new() ) {
            $shares     = Share::where( 'user_id', Auth::user()->id )->select( [ 'brandbook_id', 'action' ] )->get();
            $brandbooks = Brandbook::where( 'expires_at', '>', Carbon::now() );

            if ( $request->has( 'draft_filter' ) ) {
                if ( $request->draft_filter == 'draft' )
                    $brandbooks->where( 'status', 'draft' );
                if ( $request->draft_filter == 'official' )
                    $brandbooks->where( 'status', 'public' );
            }

            $brandbooks->where( function ( $query ) use ( $shares ) {
                $share_ids = $shares->pluck( 'brandbook_id' )->toArray();

                $query->orWhere( function ( $sub ) {
                    $sub->orWhere( 'user_id', Auth::user()->id );
                } );

                if ( !empty( $share_ids ) ) {
                    $in_ids = implode( ',', $share_ids );
                    $query->orWhereRaw( "id IN ($in_ids)" );
                }

            } );

            if ( $request->has( 'sort' ) ) {
                switch ( $request->sort ) {
                    case 'name':
                        $brandbooks->orderBy( 'brand', 'asc' );
                        break;
                    case 'updated':
                        $brandbooks->orderBy( 'updated_at', 'desc' );
                        break;
                    case 'field':
                        $brandbooks->join( 'industries', 'industries.id', '=', 'brandbooks.industry_level_1' )->orderBy( 'industries.title', 'asc' );
                        break;
                }
            } else {
                $brandbooks->orderBy( 'updated_at', 'desc' );
            }
            if ( $request->has( 'filter' ) ) {
                switch ( $request->filter ) {
                    case 'open':
                        //$brandbooks->where('status', 'draft');
                        break;
                    case 'finished':
                        //$brandbooks->where('status', 'public');
                        break;
                    case 'private':
                        // $brandbooks->where('status', 'draft');
                        break;
                    case 'public':
                        // $brandbooks->where('status', 'draft');
                        break;
                    case 'company':
                        $brandbooks->where( 'type', 'company' );
                        break;
                    case 'product':
                        $brandbooks->where( 'type', 'product' );
                        break;
                    case 'new':
                        $brandbooks->where( 'state', 'new' );
                        break;
                    case 'rebrand':
                        $brandbooks->where( 'state', 'rebrand' );
                        break;
                }
            }
            return view( 'brandbook.my' )->with( [
                'filter'       => $request->filter,
                'draft_filter' => $request->draft_filter,
                'sort'         => $request->sort,
                'brandbooks'   => $brandbooks->paginate( 16 )/*->map(function($item){
                    $item->human_date = ;
                    return $item;
                })*/
            ] );
        }
        return redirect( '/' );
    }

    public function delete( Brandbook $brandbook, Request $request ) {

        if ( Auth::check() && $brandbook->user_id == Auth::user()->id ) {
            $brandbook->delete();
        }
        return redirect()->back();
    }

    public function duplicate( Brandbook $brandbook, Request $request ) {

        if ( Auth::check() && $brandbook->user_id == Auth::user()->id ) {
            $newbrandbook             = $brandbook->replicate();
            $newbrandbook->expires_at = Carbon::now()->addMonths( 3 );
            $newbrandbook->status     = 'draft';
            $newbrandbook->watermark  = true;
            $newbrandbook->push();
            return redirect()->back();
        }
        return redirect()->back();
    }

    /**
     * Uploads misuse case
     * @param Request $request [description]
     * @return [type]           [description]
     */
    public function upload_misuse( Request $request ) {

        if ( Auth::check() ) {
            $user_id       = Auth::user()->id;
            $uploaded_file = $request->file( 'file' );
            $ext           = strtolower( $uploaded_file->getClientOriginalExtension() );
            if ( $ext == 'jpeg' ) {
                $ext = 'jpg';
            }
            $file_name = time() . '_misuse.' . $ext;
            Storage::putFileAs( '/user_files/' . $user_id, $uploaded_file, $file_name );
            $file    = Storage::get( '/user_files/' . $user_id . '/' . $file_name );
            $file_64 = false;
            if ( in_array( $ext, [ 'jpg', 'jpeg', 'png' ] ) ) {
                $file_64 = 'data:image/' . $ext . ';base64,' . base64_encode( $file );
                $file    = '';
            }
            return response()->json( [
                'logo'    => $file,
                'logo_64' => $file_64
            ] );
        }
        return response()->json( [] );
    }

    public function upload_logo( Request $request ) {

        if ( Auth::check() ) {
            $user_id       = Auth::user()->id;
            $uploaded_file = $request->file( 'file' );
            $file_name     = '_logo.svg';
            Storage::putFileAs( '/user_files/' . $user_id, $uploaded_file, $file_name );
            $file = Storage::get( '/user_files/' . $user_id . '/' . $file_name );
            if ( preg_match( '/<image/m', $file ) ) {
                Storage::delete( '/user_files/' . $user_id . '/' . $file_name );
                return response()->json( [
                    'error' => 'SVG seems to be converted from image. Please use true vector SVG.'
                ], 500 );
            }
            return response()->json( [
                'logo' => $file,
            ] );
        }
        return response()->json( [] );
    }

    public function old_upload_logo( Request $request ) {

        if ( Auth::check() ) {
            $user_id       = Auth::user()->id;
            $uploaded_file = $request->file( 'file' );
            $file_name     = '_oldlogo.svg';
            Storage::putFileAs( '/user_files/' . $user_id, $uploaded_file, $file_name );
            $file = Storage::get( '/user_files/' . $user_id . '/' . $file_name );
            if ( preg_match( '/<image/m', $file ) ) {
                Storage::delete( '/user_files/' . $user_id . '/' . $file_name );
                return response()->json( [
                    'error' => 'SVG seems to be converted from image. Please use true vector SVG.'
                ], 500 );
            }
            return response()->json( [
                'logo' => $file,
            ] );
        }
        return response()->json( [] );
    }

    public function upload_icon( Request $request ) {

        if ( Auth::check() ) {
            $user_id       = Auth::user()->id;
            $uploaded_file = $request->file( 'file' );
            $file_name     = '_icon.svg';
            Storage::putFileAs( '/user_files/' . $user_id, $uploaded_file, $file_name );
            $file = Storage::get( '/user_files/' . $user_id . '/' . $file_name );

            return response()->json( [
                'icon' => $file
            ] );
        }
        return response()->json( [] );
    }

    public function upload_icon_adv( Request $request ) {

        if ( Auth::check() ) {
            $b64           = false;
            $file_ok       = true;
            $user_id       = Auth::user()->id;
            $uploaded_file = $request->file( 'file' );
            if ( $uploaded_file->getMimeType() == 'image/svg+xml' || $uploaded_file->getMimeType() == 'image/svg' ) {
                $file_name = time() . '_adv_icon.svg';
                $url       = Storage::putFileAs( '/user_files/' . $user_id, $uploaded_file, $file_name );
                $file      = Storage::get( '/user_files/' . $user_id . '/' . $file_name );
            } else {
                $file_name = time() . '_adv_icon.' . $uploaded_file->getClientOriginalName();
                $url       = Storage::putFileAs( '/user_files/' . $user_id, $uploaded_file, $file_name );
                $file      = 'data:' . $uploaded_file->getMimeType() . ';base64,' . base64_encode( Storage::get( '/user_files/' . $user_id . '/' . $file_name ) );
                $b64       = true;

                Image::configure( [ 'driver' => 'imagick' ] );
                $img = Image::make( storage_path( 'app/user_files/' . $user_id . '/' . $file_name ) );
                if ( $img->width() < 500 && $img->height() < 500 )
                    $file_ok = false;
            }

            return response()->json( [
                'image'    => $file,
                'url'      => $url,
                'b64'      => $b64,
                'validate' => $file_ok
            ] );
        }
        return response()->json( [] );
    }

    public function upload_icon_family( Request $request ) {

        if ( Auth::check() ) {
            $svg           = false;
            $user_id       = Auth::user()->id;
            $uploaded_file = $request->file( 'file' );
            $file_name     = time() . $uploaded_file->getClientOriginalName();
            Storage::put( 'user_files/' . $user_id . '/' . $file_name, $uploaded_file->get() );
            $file = Storage::get( '/user_files/' . $user_id . '/' . $file_name );

            $url = '/user_files/' . $user_id . '/' . $file_name;
            if ( strpos( $uploaded_file->getMimeType(), 'svg' ) !== false ) {
                $svg     = true;
                $file_64 = $file;
            } else {
                $file_64 = 'data:' . $uploaded_file->getMimeType() . ';base64,' . base64_encode( $file );
            }

            return response()->json( [
                'image' => $file_64,
                // 'file'=>$file,
                'url'   => $url,
                'svg'   => $svg
            ] );
        }
        return response()->json( [] );
    }

    public function upload_mockup( Request $request ) {

        if ( Auth::check() ) {
            $user_id       = Auth::user()->id;
            $uploaded_file = $request->file( 'file' );
            $file_name     = time() . '_mockup.' . $uploaded_file->getClientOriginalName();
            $url           = Storage::putFileAs( '/user_files/' . $user_id, $uploaded_file, $file_name );
            $file          = 'data:' . $uploaded_file->getMimeType() . ';base64,' . base64_encode( Storage::get( '/user_files/' . $user_id . '/' . $file_name ) );

            return response()->json( [
                'image' => $file,
                'url'   => $url,
            ] );
        }
        return response()->json( [] );
    }

    public function upload_font( Request $request ) {

        if ( Auth::check() ) {
            $user_id       = Auth::user()->id;
            $uploaded_file = $request->file( 'file' );
            $extension     = $uploaded_file->extension() == '' ? 'otf' : $uploaded_file->extension();
            $file_name     = time() . '_' . $request->type . '_' . $request->index . '.' . $extension;
            $file          = Storage::putFileAs( '/public/user_files/' . $user_id, $uploaded_file, $file_name );

            return response()->json( [
                'font' => str_replace( 'public', '/storage', $file )
            ] );
        }
        return response()->json( [] );
    }

    public function create( Request $request ) {

        if ( Auth::check() ) {
            $bb             = new Brandbook;
            $bb->user_id    = Auth::user()->id;
            $bb->status     = 'draft';
            $bb->expires_at = Carbon::now()->addMonths( 3 );
            $bb->watermark  = true;
            $bb->save();
            return response()->json( [ 'id' => $bb->id, 'left_credits' => Auth::user()->credits() ] );
        }
        return response()->json( [] );
    }


    public function saveCustom( Request $request ) {

        if ( Auth::check() ) {
            $bb = Brandbook::findOrFail( $request->id );
            if ( $bb->user_id == Auth::user()->id || Auth::user()->isAdmin() ) {
                if ( $request->has( 'custom-cover-image' ) ) {
                    $custom_logo     = $this->saveCustomCoverImage( $request->file( 'custom-cover-image' ), $bb->user_id, $bb->id );
                    $bb->custom_logo = $custom_logo;
                }

                $custom = [];

                if ( $request->has( 'title_family' ) && $request->has( 'title_weight' ) ) {
                    $custom[ 'title_family' ]   = $request->title_family;
                    $custom[ 'title_weight' ]   = $request->title_weight;
                    $custom[ 'title_category' ] = $request->title_category;
                }

                if ( $request->has( 'body_family' ) && $request->has( 'body_weight' ) ) {
                    $custom[ 'body_family' ]   = $request->body_family;
                    $custom[ 'body_weight' ]   = $request->body_weight;
                    $custom[ 'body_category' ] = $request->body_category;
                }

                $bb->custom = $custom;
                $bb->save();

                //remove brandbook preview to request image regeneration
                if ( file_exists( storage_path( 'previews/' . $bb->id . '.jpg' ) ) ) {
                    unlink( storage_path( 'previews/' . $bb->id . '.jpg' ) );
                }

                $themes = Theme::where( 'is_active', true )->get();
                $pdfs   = [];
                foreach ( $themes as $theme ) {
                    $pdfs[ $theme->id ] = $this->pdf_prepare( $bb->id, $theme->id, false, true );
                }
                Brandbook::where( 'id', $bb->id )->update( [ 'pdf_link' => json_encode( $pdfs ) ] );
                // $bb->save();
                return response()->json( $pdfs );
            }
        }
    }

    public function save( Request $request ) {

        if ( Auth::check() ) {
            $bb = Brandbook::findOrFail( $request->id );
            if ( $bb->user_id == Auth::user()->id || Auth::user()->isAdmin() ) {


                $bb->brand               = $request->brand;
                $bb->tag                 = $request->tag;
                $bb->type                = $request->type;
                $bb->state               = $request->state;
                $bb->industry_level_1    = $request->industry_level_1;
                $bb->industry_level_2    = $request->industry_level_2;
                $bb->logo                = $request->logo;
                $bb->logo_b64            = $request->logo_b64;
                $bb->icon                = $request->icon;
                $bb->icon_b64            = $request->icon_b64;
                $bb->icon_family         = $request->icon_family;
                $bb->icon_title          = $request->icon_title;
                $bb->icon_caption        = $request->icon_caption;
                $bb->approved            = $request->approved;
                $bb->rejected            = $request->rejected;
                $bb->approved_icon       = $request->approved_icon;
                $bb->rejected_icon       = $request->rejected_icon;
                $bb->proportions         = $request->proportions;
                $bb->space               = $request->space;
                $bb->size                = $request->size;
                $bb->logo_w              = $request->logo_w;
                $bb->logo_h              = $request->logo_h;
                $bb->color_scheme_mode   = $request->color_scheme_mode;
                $bb->generated_colors    = $request->generated_colors;
                $bb->colors_used         = $request->colors_used;
                $bb->fonts_main          = $request->fonts_main;
                $bb->fonts_secondary     = $request->fonts_secondary;
                $bb->vision              = $request->vision;
                $bb->mission             = $request->mission;
                $bb->core_values         = $request->core_values;
                $bb->colors_list         = $request->colors_list;
                $bb->main_color          = $request->main_color;
                $bb->main_color_hex      = $request->main_color_hex;
                $bb->secondary_color_hex = $request->secondary_color_hex;
                $bb->completed           = $request->step;
                $bb->old_logo            = $request->old_logo_b64;
                $bb->new_color_scheme    = $request->new_color_scheme;
                $bb->mockups             = $request->mockups;
                $bb->missuses            = $request->missuses;
                $bb->logo_versions       = $request->logo_versions;
                $bb->all_logo_variations = $request->all_logo_variations;
                $bb->all_icon_variations = $request->all_icon_variations;
                $bb->theme               = $request->theme;
                $bb->voices              = $request->voices;
                $bb->version             = config( 'app.book_version' );
                $bb->save();
            }
        }
    }

    public function saveSeparate( Request $request ) {

        if ( Auth::check() ) {
            $bb = Brandbook::findOrFail( $request->id );
            if ( $bb->user_id == Auth::user()->id || Auth::user()->isAdmin() ) {
                if ( !empty( $request->theme ) ) {
                    $bb->theme = $request->theme;
                }
                $bb->save();
            }
        }
    }

    public function resume( Request $request ) {

        if ( Auth::check() ) {


            $bb = Brandbook::findOrFail( $request->id );

            if ( !empty( $bb->pdf_link ) ) {
                $pdf_links = json_decode( $bb->pdf_link, true );
                $match     = true;

                if ( is_int( array_keys( $pdf_links )[ 0 ] ) ) {
                    $themes = Theme::active()->get()->keyBy( 'id' )->toArray();

                    if ( count( $pdf_links ) != count( $themes ) ) {
                        $match = false;
                    } else {
                        foreach ( $pdf_links as $theme_id => $pdf_link ) {
                            if ( !array_key_exists( $theme_id, $themes ) ) {
                                $match = false;
                                break;
                            }
                        }
                    }

                    if ( !$match ) {
                        $pdfs = [];
                        foreach ( $themes as $theme ) {
                            $pdfs[ $theme[ 'id' ] ] = $this->pdf_prepare( $bb->id, $theme[ 'id' ], false, true );
                        }
                        $bb->pdf_link = json_encode( $pdfs );
                        $bb->update();
                    }
                }
            }


            if ( !empty( $bb->industry_level_1 ) )
                $bb->industry_level_1_text = $bb->industry_1->title;
            else
                $bb->industry_level_1_text = '';
            if ( !empty( $bb->industry_level_2 ) )
                $bb->industry_level_2_text = $bb->industry_2->title;
            else
                $bb->industry_level_2_text = '';

            return response()->json( $bb, 200 );
        }
    }

    public function load( Request $request ) {

        if ( Auth::check() || Brandbook::where( 'id', $request->id )->whereNotNull( 'shared_link' )->count() > 0 ) {
            $bb    = Brandbook::findOrFail( $request->id );
            $theme = $bb->theme;

            $bb->approved      = json_decode( $bb->approved );
            $bb->rejected      = json_decode( $bb->rejected );
            $bb->approved_icon = json_decode( $bb->approved_icon );

            $bb->logo_versions = json_decode( $bb->logo_versions );
            $bb->missuses      = json_decode( $bb->missuses );
            $bb->mockups       = json_decode( $bb->mockups );
            $bb->icon_family   = json_decode( $bb->icon_family, true );
            if ( !is_array( $bb->icon_family ) )
                $bb->icon_family = [];
            $if = [];
            foreach ( $bb->icon_family as $i => $item ) {
                $item[ 'icon_b64' ] = base64_encode( file_get_contents( storage_path( 'app/' . $item[ 'icon' ] ) ) );
                $if[ $i ]           = $item;
            }
            $bb->icon_family = $if;


            $bb->fonts_main      = collect( json_decode( $bb->fonts_main, true ) );
            $bb->fonts_secondary = collect( json_decode( $bb->fonts_secondary, true ) );
            $ext                 = pathinfo( $bb->user->avatar, PATHINFO_EXTENSION );

            $bb_pdf_link = json_decode( $bb->pdf_link, true );

            if ( !is_array( $bb_pdf_link ) || !count( $bb_pdf_link ) ) {
                $pdfs = [];

                $pdfs[ $theme ] = app( BrandbookController::class )->pdf_prepare( $bb->id, $theme, false, true );

                $bb->pdf_link = json_encode( $pdfs );
                $bb->update();
                $bb_pdf_link = $pdfs;
            }

            $pdf_link = isset( $bb_pdf_link[ $bb->theme ] )
                ?
                $bb_pdf_link[ $bb->theme ]
                :
                reset( $bb_pdf_link );

            return response()->json( [
                'colors'        => json_decode( $bb->colors_list ),
                'pdf'           => $pdf_link,
                'pdf_links'     => $bb_pdf_link,
                'title'         => $bb->brand . ' ' . __( 'Brandbook' ),
                'logo'          => route( 'brandbook.logo', $bb->id ),
                'can_export'    => true,
                'can_edit'      => ( Auth::user()->can_do( 'edit', $bb ) ),
                'is_editable'   => $bb->version >= config( 'app.editable_version' ),
                'can_download'  => ( Auth::user()->can_do( 'download', $bb ) ),
                'theme'         => $bb->theme,
                'can_duplicate' => ( Auth::user()->can_do( 'duplicate', $bb ) ),
                'expires_at'    => $bb->expires_at->format( 'd.m.Y' ),
                'can_remove_wm' => Auth::user()->can_do( 'can_remove_wm', $bb ),
                'custom'        => $bb->custom,
                'status'        => $bb->status
            ] );
        }
    }

    public function load_embed( Request $request ) {

        // if(Auth::check() || Brandbook::where('id', $request->id)->whereNotNull('shared_link')->count()>0){
        $bb    = Brandbook::findOrFail( $request->id );
        $theme = $bb->theme;


        $bb->colors_list   = collect( [ json_decode( $bb->main_color ) ] )->merge( collect( json_decode( $bb->colors_list ) ) )->map( function ( $color ) {

            if ( $color->color->loaded == false ) {
                $data         = json_decode( file_get_contents( "http://www.thecolorapi.com/id?format=json&hex=" . str_replace( '#', '', $color->color->hex->value ) ) );
                $data->loaded = true;
                $color->color = $data;
            }
            $color->color->scheme = json_decode( file_get_contents( 'http://www.thecolorapi.com/scheme?format=json&named=false&hex=' . str_replace( '#', '', $color->color->hex->value ) . '&count=5' ) );
            $hex                  = new HEXValue( str_replace( '#', '', $color->color->hex->value ) );
            $pantoneSolidCoated   = new PANTONESystem(
                PANTONEEnum::PANTONE_PLUS_SOLID_COATED()
            );
            try {
                $pantone        = $pantoneSolidCoated->findColor( $hex, 15 );
                $color->pantone = $pantone->getIterator()->current();
            } catch ( Exception $e ) {

            }
            return $color;
        } )->all();
        $bb->approved      = json_decode( $bb->approved );
        $bb->rejected      = json_decode( $bb->rejected );
        $bb->approved_icon = json_decode( $bb->approved_icon );

        $bb->logo_versions = json_decode( $bb->logo_versions );
        $bb->missuses      = json_decode( $bb->missuses );
        $bb->mockups       = json_decode( $bb->mockups );
        $bb->icon_family   = json_decode( $bb->icon_family, true );
        $if                = [];
        foreach ( $bb->icon_family as $i => $item ) {
            $item[ 'icon_b64' ] = base64_encode( file_get_contents( storage_path( 'app/' . $item[ 'icon' ] ) ) );
            $if[ $i ]           = $item;
        }
        $bb->icon_family = $if;

        $bb->fonts_main      = collect( json_decode( $bb->fonts_main, true ) );
        $bb->fonts_main      = $bb->fonts_main->map( function ( $item ) {

            $path = str_replace( '/storage', '/public', $item[ 'file' ] );
            if ( strpos( $item[ 'file' ], 'fonts.gstatic.com' ) == false )
                $data = file_get_contents( public_path() . $item[ 'file' ] );
            else
                $data = file_get_contents( $item[ 'file' ] );
            $item[ 'font' ] = 'data:font/truetype;charset=utf-8;base64,' . base64_encode( $data );
            return $item;
        } );
        $bb->fonts_secondary = collect( json_decode( $bb->fonts_secondary, true ) );
        $bb->fonts_secondary = $bb->fonts_secondary->map( function ( $item ) {

            $path = str_replace( '/storage', '/public', $item[ 'file' ] );
            if ( strpos( $item[ 'file' ], 'fonts.gstatic.com' ) == false )
                $data = file_get_contents( public_path() . $item[ 'file' ] );
            else
                $data = file_get_contents( $item[ 'file' ] );
            $item[ 'font' ] = 'data:font/truetype;charset=utf-8;base64,' . base64_encode( $data );
            return $item;
        } );
        $ext                 = pathinfo( $bb->user->avatar, PATHINFO_EXTENSION );
        $bb->user->avatar    = "data:image/{$ext};base64," . base64_encode( file_get_contents( $bb->user->avatar ) );

        return response()->json( [
            'colors'        => $bb->colors_list,
            'pdf'           => $bb->pdf_link,
            'title'         => $bb->brand . ' ' . __( 'Brandbook' ),
            'logo'          => route( 'brandbook.logo', $bb->id ),
            'can_export'    => false,
            'can_download'  => ( Auth::user()->can_do( 'download', $bb ) ),
            'can_duplicate' => false,
            'is_editable'   => $bb->version >= config( 'app.editable_version' ),
            'can_edit'      => false,
            'can_remove_wm' => Auth::user()->can_do( 'can_remove_wm', $bb ),
            'custom'        => $bb->custom,
            'status'        => $bb->status
        ] );
        $pdf->save( $file );
        return response()->json( [ 'url' => $file ] );
    }

    public function get_html( $id, $theme, $load = true ) {

        $bb = Brandbook::findOrFail( $id );
        if ( $theme === false )
            $theme = $bb->theme;
        if ( strpos( $theme, 'themes/' ) === false ) {
            if ( intval( $theme ) == 0 && $theme == $bb->theme ) {
                $t     = Theme::where( 'name', $theme )->first();
                $theme = json_decode( $t->file, true );
                $theme = $theme[ 0 ][ 'download_link' ];
            } else {
                $t     = Theme::findOrFail( $theme );
                $theme = json_decode( $t->file, true );
                $theme = $theme[ 0 ][ 'download_link' ];
            }
        }

        copy( storage_path( 'app/public/' . $theme ), resource_path( 'views' ) . '/themes/' . str_replace( '.php', '.blade.php', basename( $theme ) ) );

        $theme = 'themes.' . str_replace( '.php', '', basename( $theme ) );


        $bb->colors_list
            = /*collect([json_decode($bb->main_color)])->merge(*/
            collect( json_decode( $bb->colors_list ) )/*)*/ ->map( function ( $color ) use ( $load ) {

                if ( !isset( $color->color ) ) {
                    $clr                      = $color;
                    $color                    = new \stdClass;
                    $color->color             = new \stdClass;
                    $color->color->loaded     = false;
                    $color->color->hex        = new \stdClass;
                    $color->color->hex->value = $clr;
                    $color->show_shades       = true;
                }

                if ( !property_exists( $color, 'shades' ) ) {
                    $color->show_shades = true;
                }

                if ( $load ) {
                    if ( isset( $color->color ) && isset( $color->color->loaded ) && $color->color->loaded == false ) {
                        $data         = json_decode( file_get_contents( "http://www.thecolorapi.com/id?format=json&hex=" . str_replace( '#', '', $color->color->hex->value ) ) );
                        $data->loaded = true;
                        $color->color = $data;
                    }
                    $color->color->scheme = json_decode( file_get_contents( 'http://www.thecolorapi.com/scheme?format=json&named=false&hex=' . str_replace( '#', '', $color->color->hex->value ) . '&count=5' ) );
                }
                $hex                = new HEXValue( str_replace( '#', '', $color->color->hex->value ) );
                $pantoneSolidCoated = new PANTONESystem(
                    PANTONEEnum::PANTONE_PLUS_SOLID_COATED()
                );
                try {
                    $pantone        = $pantoneSolidCoated->findColor( $hex, 15 );
                    $color->pantone = $pantone->getIterator()->current();
                } catch ( Exception $e ) {
                    $pantone = '';
                }
                return $color;
            } )->all();
        $bb->approved = json_decode( $bb->approved );
        $bb->rejected = json_decode( $bb->rejected );


        $bb->approved_icon = json_decode( $bb->approved_icon, true );

        if ( !is_array( $bb->core_values ) )
            $bb->core_values = json_decode( $bb->core_values, true );

        if ( !is_array( $bb->core_values ) )
            $bb->core_values = [];
        if ( !is_array( $bb->approved_icon ) )
            $bb->approved_icon = [];
        if ( !is_array( $bb->approved ) )
            $bb->approved = [];
        if ( !is_array( $bb->rejected ) )
            $bb->rejected = [];

        $bb->logo_versions = json_decode( $bb->logo_versions );
        $bb->missuses      = json_decode( $bb->missuses );
        $bb->mockups       = json_decode( $bb->mockups );
        $bb->icon_family   = json_decode( $bb->icon_family, true );
        $if                = [];
        foreach ( $bb->icon_family as $i => $item ) {
            $item[ 'icon_b64' ] = base64_encode( file_get_contents( storage_path( 'app/' . $item[ 'icon' ] ) ) );
            $if[ $i ]           = $item;
        }
        $bb->icon_family = $if;


        // print_r($bb->approved_icon);
        $bb->fonts_main = collect( json_decode( $bb->fonts_main, true ) );
        // if($load){
        $bb->fonts_main = $bb->fonts_main->map( function ( $item ) {

            $path = str_replace( '/storage', '/public', $item[ 'file' ] );
            if ( strpos( $item[ 'file' ], 'fonts.gstatic.com' ) == false )
                $data = file_get_contents( public_path() . $item[ 'file' ] );
            else
                $data = file_get_contents( $item[ 'file' ] );
            $item[ 'font' ] = 'data:font/truetype;charset=utf-8;base64,' . base64_encode( $data );
            if ( !isset( $item[ 'index' ] ) )
                $item[ 'index' ] = uniqid();
            return $item;
        } );

        $bb->fonts_secondary = collect( json_decode( $bb->fonts_secondary, true ) );
        $bb->fonts_secondary = $bb->fonts_secondary->map( function ( $item ) {

            $path = str_replace( '/storage', '/public', $item[ 'file' ] );
            if ( strpos( $item[ 'file' ], 'fonts.gstatic.com' ) == false )
                $data = file_get_contents( public_path() . $item[ 'file' ] );
            else
                $data = file_get_contents( $item[ 'file' ] );
            $item[ 'font' ] = 'data:font/truetype;charset=utf-8;base64,' . base64_encode( $data );
            return $item;
        } );
        if ( $load ) {
            $ext              = pathinfo( $bb->user->avatar, PATHINFO_EXTENSION );
            $bb->user->avatar = '';//"data:image/{$ext};base64,".base64_encode(file_get_contents(url($bb->user->avatar)));
        }

        $icon   = $this->get_image_dimensions( $bb->icon );
        $logo_d = $this->get_image_dimensions( $bb->logo );

        $bb->logo_w = $logo_d[ 'w' ];
        $bb->logo_h = $logo_d[ 'h' ];

        $bb_pdf_link = json_decode( $bb->pdf_link, true );
        if ( isset( $bb_pdf_link[ $bb->theme ] ) )
            $bb->pdf_link = $bb_pdf_link[ $bb->theme ];

        $all_logos = [];
        $all_icons = [];
        if ( !empty( $bb->all_logo_variations ) ) {
            foreach ( json_decode( $bb->all_logo_variations, true ) as $all_logo_variation ) {
                $all_logos[ $all_logo_variation[ 'id' ] ] = $all_logo_variation;
            }
        }

        if ( !empty( $bb->all_icon_variations ) ) {
            foreach ( json_decode( $bb->all_icon_variations, true ) as $all_icon_variation ) {
                $all_icons[ $all_icon_variation[ 'id' ] ] = $all_icon_variation;
            }
        }

        $bb->all_icon_variations = $all_icons;
        $bb->all_logo_variations = $all_logos;

        $html = str_replace( '</style>', '</style>', str_replace( '<link href="https://fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">', '', str_replace( '<div class="page-break"></div>', '', View::make( $theme, [
            'data'   => $bb, 'icon_w' => $icon[ 'w' ],
            'icon_h' => $icon[ 'h' ]
        ] )->render() ) ) );

        return response()->json( [
            'colors'   => $bb->colors_list,
            'theme'    => $bb->theme,
            'pdf_link' => $bb->pdf_link,
            'brand'    => $bb->brand,
            'logo'     => $bb->logo_b64,
            'icon'     => $bb->icon_b64,

            'html'          => $html,
            'industry'      => $bb->industries_title(),
            'can_export'    => true,
            'can_download'  => ( Auth::user()->can_do( 'download', $bb ) ),
            'can_duplicate' => ( Auth::user()->left_credits > 0 )
        ] );
        $pdf->save( $file );

        return response()->json( [ 'url' => $file ] );
    }

    public function removeWatermarkAfterPayment( $book_id ) {
        $brandbook = Brandbook::find( $book_id );
        if ( !$brandbook->watermark ) {
            $brandbook->status     = Brandbook::BOOK_STATUSES_PUBLIC;
            $brandbook->expires_at = $brandbook->expires_at->addMonths( 3 );
            $brandbook->pdf_link   = json_encode( $this->generatePDF( $brandbook ) );
            $brandbook->update();
            return redirect( 'my/view/' . $book_id );
        }
    }

    public function removeWatermark( Request $request ) {
        $id   = $request->id;
        $user = Auth::user();
        if ( $user->credits() > 0 ) {
            /**
             * @var $brandbook Brandbook
             */
            $brandbook = $user->brandbooks()->where( 'id', $id )->first();
            if ( !empty( $brandbook ) ) {
                if ( $user->can_do( 'edit', $brandbook ) ) {

                    $brandbook->status     = Brandbook::BOOK_STATUSES_PUBLIC;
                    $brandbook->expires_at = $brandbook->expires_at->addMonths( 3 );
                    $brandbook->watermark  = false;
                    $brandbook->update();
                    $brandbook->pdf_link = json_encode( $this->generatePDF( $brandbook ) );
                    $brandbook->update();
                    $user->minusCredits();
                    $user->update();
                    return response()->json( [ 'message' => 'ok' ] );
                }
            } else {
                return response()->json( [ 'message' => 'Book not found' ], 404 );
            }
        } else {
            return response()->json( [ 'message' => 'Not enough credits' ], 402 );
        }
    }

    public function get_image_dimensions( $image ) {

        if ( !empty( $image ) && $image != 'skipped' && $image != '[]' ) {

            if($size = $this->get_svg_size($image)){
                return [ 'w' => $size['width'], 'h' => $size['height'] ];
            }

            $fn = storage_path( time() . uniqid() . '.svg' );
            file_put_contents( $fn, $image );
            Image::configure( [ 'driver' => 'imagick' ] );
            $img = Image::make( $fn );
            $w   = $img->width();
            $h   = $img->height();
            unlink( $fn );
            return [ 'w' => $w, 'h' => $h ];
        } else {
            return [ 'w' => 50, 'h' => 50 ];
        }
    }

    public function edit( Request $request ) {

        if ( Auth::check() ) {
            return $this->get_html( $request->id, false );
        }
    }

    public function logo_download( Brandbook $brandbook ) {

        //generate assets here
        if ( !Auth::user()->can_do( 'download', $brandbook ) ) {
            return redirect()->back();
        }
        //add background and circles according to settings (for v3)
        $files = [];
        if ( !empty( $brandbook->logo ) )
            $this->process_image( $brandbook->logo, $brandbook->id, 'logos', 'logo', $files );

        $versions = json_decode( $brandbook->logo_versions, true );
        if ( !empty( $versions[ 1 ] ) ) {
            $this->process_image( $versions[ 1 ][ 'logo' ], $brandbook->id, 'alternative-logos', 'logo-1', $files );
        }
        if ( !empty( $versions[ 2 ] ) ) {
            $this->process_image( $versions[ 2 ][ 'logo' ], $brandbook->id, 'alternative-logos', 'logo-2', $files );
        }

        $previous_title = '';
        if ( !empty( $brandbook->approved ) ) {
            foreach ( json_decode( $brandbook->approved, true ) as $c => $logo_v ) {
                $processed_title = $this->process_logo_title_for_file( $logo_v[ 'title' ] );
                $path            = ( $processed_title == $previous_title ) ? 'alternative-logos' : 'logos';
                $this->process_image( $logo_v[ 'logo' ], $brandbook->id, $path, 'logo_' . $c . '_' . $processed_title, $files, ( !empty( $icon_v[ 'background' ] ) && $icon_v[ 'background' ] != 'transparent' ) ? $icon_v[ 'background' ] : false );
                $previous_title = $processed_title;
            }
        }


        if ( !empty( $brandbook->icon ) && $brandbook->icon != 'skipped' && $brandbook->icon != '[]' ) {
            $this->process_image( $brandbook->icon, $brandbook->id, 'icons', 'icon', $files );
        }

        if ( !empty( $brandbook->approved_icon ) ) {
            foreach ( json_decode( $brandbook->approved_icon, true ) as $icon_v ) {
                if ( $icon_v[ 'icon' ] !== 'skipped' )
                    $this->process_image(
                        $icon_v[ 'icon' ], $brandbook->id, 'icons', 'icon_' . $this->process_logo_title_for_file( $icon_v[ 'title' ] ),
                        $files,
                        ( !empty( $icon_v[ 'background' ] ) && $icon_v[ 'background' ] != 'transparent' ) ? $icon_v[ 'background' ] : false,
                        ( isset( $icon_v[ 'border_radius' ] ) && !empty( $icon_v[ 'border_radius' ] ) && $icon_v[ 'border_radius' ] == '50%' ) ? true : false
                    );
            }
        }

        if ( !empty( $brandbook->core_values ) ) {
            foreach ( json_decode( $brandbook->core_values, true ) as $i => $core_v ) {
                if ( !empty( $core_v[ 'url' ] ) )
                    $this->process_image( file_get_contents( storage_path( 'app/' . $core_v[ 'url' ] ) ), $brandbook->id, 'values', 'icon_' . $i . '_' . $this->process_logo_title_for_file( $core_v[ 'title' ] ), $files );
            }
        }

        if ( !empty( $brandbook->icon_family ) ) {
            foreach ( json_decode( $brandbook->icon_family, true ) as $i => $core_v ) {
                if ( !empty( $core_v[ 'icon' ] ) )
                    $this->process_image( file_get_contents( storage_path( 'app/' . $core_v[ 'icon' ] ) ), $brandbook->id, 'featured-icons', 'icon_' . $i . '_' . $this->process_logo_title_for_file( $core_v[ 'title' ] ), $files );
            }
        }

        if ( !empty( $brandbook->fonts_main ) ) {
            $path_ = 'fonts-main';
            if ( !file_exists( storage_path( 'bbassets/' . $brandbook->id . '/' . $path_ ) ) )
                mkdir( storage_path( 'bbassets/' . $brandbook->id . '/' . $path_ ) );
            foreach ( json_decode( $brandbook->fonts_main, true ) as $i => $font ) {
                if ( !is_null( $font ) && !empty( $font[ 'file' ] ) && !preg_match( '/gstatic/', $font[ 'file' ] ) ) {
                    $name = 'font_' . $i;
                    $path = 'bbassets/' . $brandbook->id . '/' . $path_ . '/' . $name;
                    $file = storage_path( $path . '.' . pathinfo( $font[ 'file' ], PATHINFO_EXTENSION ) );
                    file_put_contents( $file, file_get_contents( storage_path( str_replace( 'storage/', 'app/public/', $font[ 'file' ] ) ) ) );
                    $files[] = $file;
                }
            }
        }
        if ( !empty( $brandbook->fonts_secondary ) ) {
            $path_ = 'fonts-secondary';
            if ( !file_exists( storage_path( 'bbassets/' . $brandbook->id . '/' . $path_ ) ) )
                mkdir( storage_path( 'bbassets/' . $brandbook->id . '/' . $path_ ) );
            foreach ( json_decode( $brandbook->fonts_secondary, true ) as $i => $font ) {
                if ( !is_null( $font ) && !empty( $font[ 'file' ] ) && !preg_match( '/gstatic/', $font[ 'file' ] ) ) {
                    $name = 'font_' . $i;
                    $path = 'bbassets/' . $brandbook->id . '/' . $path_ . '/' . $name;
                    $file = storage_path( $path . '.' . pathinfo( $font[ 'file' ], PATHINFO_EXTENSION ) );
                    file_put_contents( $file, file_get_contents( storage_path( str_replace( 'storage/', 'app/public/', $font[ 'file' ] ) ) ) );
                    $files[] = $file;
                }
            }
        }


        if ( false ) { //TODO think about trigger to remove watermark
            //regenerate themes to remove draft image
            $themes = Theme::active()->get()->keyBy( 'id' )->toArray();
            $pdfs   = [];
            foreach ( $themes as $theme ) {
                $pdfs[ $theme[ 'id' ] ] = $this->pdf_prepare( $brandbook->id, $theme[ 'id' ], false, true );
            }
            $brandbook->pdf_link = json_encode( $pdfs );
            $brandbook->save();
        }

        if ( isset( $brandbook->theme ) && isset( $brandbook->pdf_link ) && !empty( $brandbook->theme ) && $brandbook->theme != null && $brandbook->pdf_link != null && !empty( $brandbook->pdf_link ) ) {
            $file = $this->pdf_download( $brandbook );
            file_put_contents( storage_path() . '/pdf-spread-' . $brandbook->id . '.pdf', $file );
            $files[] = storage_path() . '/pdf-spread-' . $brandbook->id . '.pdf';
        }

        $archiveFile     = storage_path( "bbassets/{$brandbook->id}-assets.zip" );
        $relative_path   = storage_path( "bbassets/{$brandbook->id}/" );
        $relative_path_2 = storage_path( '/app/public/user_files/' . $brandbook->user_id . '/' );
        $relative_path_3 = storage_path() . '/';
        $archive         = new \ZipArchive();
        if ( $archive->open( $archiveFile, \ZipArchive::CREATE | \ZipArchive::OVERWRITE ) ) {
            $archive->addEmptyDir( 'logos' );
            $archive->addEmptyDir( 'icons' );
            $archive->addEmptyDir( 'values' );
            $archive->addEmptyDir( 'featured-icons' );
            $archive->addEmptyDir( 'fonts-main' );
            $archive->addEmptyDir( 'fonts-secondary' );
            // Loop through all the files and add them to the archive.
            foreach ( $files as $file ) {
                if ( $archive->addFile( $file, str_replace( $relative_path_3, '', str_replace( $relative_path_2, '', str_replace( $relative_path, '', $file ) ) ) ) ) {
                    // Do something here if addFile succeeded, otherwise this statement is unnecessary and can be ignored.
                    continue;
                } else {
                    throw new \Exception( "File [`{$file}`] could not be added to the zip file: " . $archive->getStatusString() );
                }
            }

            // Close the archive.
            if ( $archive->close() ) {
                // Archive is now downloadable ...
                // return response()->streamDownload(function()use($brandbook){
                // echo $brandbook->logo;
                // }, $brandbook->id.'.zip');

                return response()->download( $archiveFile, basename( $archiveFile ) )->deleteFileAfterSend( true );
            } else {
                throw new \Exception( "Could not close zip file: " . $archive->getStatusString() );
            }
        } else {
            throw new \Exception( "Zip file could not be created: " . $archive->getStatusString() );
        }
    }

    public function process_logo_title_for_file( $text ) {

        try {
            // replace non letter or digits by -
            $text = preg_replace( '~[^\pL\d]+~u', '-', $text );

            // transliterate
            $text = iconv( 'utf-8', 'us-ascii//TRANSLIT', $text );

            // remove unwanted characters
            $text = preg_replace( '~[^-\w]+~', '', $text );

            // trim
            $text = trim( $text, '-' );

            // remove duplicate -
            $text = preg_replace( '~-+~', '-', $text );

            // lowercase
            $text = strtolower( $text );
        } catch ( \Exception $e ) {
            return 'n-a';
        }

        if ( empty( $text ) ) {
            return 'n-a';
        }

        return $text;
    }

    public function get_svg_size($image){

        try {

            $dom = new \DOMDocument( '1.0', 'utf-8' );
            $dom->loadXML( $image );
            $svg = $dom->documentElement;

            foreach ($svg->attributes as $attr)
            {
                $attributes[$attr->nodeName] = $attr->nodeValue;
            }

            if(isset($attributes['height']) and isset($attributes['width'])){
                return ['width' => intval($attributes['width']), 'height' => intval($attributes['height'])];
            }
            return false;

        }catch (\Exception $exception){
            return false;
        }

    }

    public function process_image( $image, $id, $path, $name, &$list, $background = false, $radius = false ) {

        $svg = $image;

        if ( !file_exists( storage_path( 'bbassets/' . $id ) ) )
            mkdir( storage_path( 'bbassets/' . $id ) );
        if ( !file_exists( storage_path( 'bbassets/' . $id . '/' . $path ) ) )
            mkdir( storage_path( 'bbassets/' . $id . '/' . $path ) );
        $path = 'bbassets/' . $id . '/' . $path . '/' . $name;
        $file = storage_path( $path . '.svg' );
        Image::configure( [ 'driver' => 'imagick' ] );

        //$image = str_replace(' viewBox', ' transform="scale(0.2)" viewBox', $image); you easy can change image size by transform
        file_put_contents( $file, $image );

        if($size = $this->get_svg_size($image)){
            $height = $size['height'];
            $width  = $size['width'];
            $is_svg = true;
        }else{
            $img = Image::make( $file ); // this is SVG
            //get height and width of the logo
            $height = $img->height();
            $width  = $img->width();
            $is_svg = strpos( $img->mime(), 'svg' ) !== false;
        }

        if ( $height > $width ) {
            $n_height = 1200;
            $n_width  = 1200 * $width / $height;
        } else {
            $n_width  = 1200;
            $n_height = 1200 * $height / $width;
        }

        $x = ( 1200 - $n_width ) / 2;
        $y = ( 1200 - $n_height ) / 2;

        if ( $is_svg ) {
            $this->resize_svg( $file, $n_height, $n_width );
            $list[] = storage_path( $path . '.svg' );

            $img      = Image::make( $file ); //this is SVG
            $file_png = str_replace( '.svg', '.png', $file );
            exec( 'rsvg-convert ' . $file . ' -o ' . $file_png );
            $img_px = Image::make( $file_png );

            if ( $background ) {
                $image    = Image::canvas( 1200, 1200 );
                $image_px = Image::canvas( 1200, 1200 );
                if ( $radius ) {
                    $image->circle( 1200, 600, 600, function ( $drw ) use ( $background ) {

                        $drw->background( $background );
                    } );
                    $image_px->circle( 1200, 600, 600, function ( $drw ) use ( $background ) {

                        $drw->background( $background );
                    } );
                } else {
                    $image->rectangle( 0, 0, 1200, 1200, function ( $drw ) use ( $background ) {

                        $drw->background( $background );
                    } );
                    $image_px->rectangle( 0, 0, 1200, 1200, function ( $drw ) use ( $background ) {

                        $drw->background( $background );
                    } );
                }
                $img->resize( $img->width() * .6, $img->height() * .6 );
                $img_px->resize( $img_px->width() * .6, $img_px->height() * .6 );
                $image->insert( $img, 'center' );
                $image_px->insert( $img_px, 'center' );

                $image_px->save( storage_path( $path . '.png' ), 100, 'png' );
                $list[] = storage_path( $path . '.png' );
                $image_px->save( storage_path( $path . '.jpg' ), 100, 'jpg' );
                $list[] = storage_path( $path . '.jpg' );

                // $svg = $image;//Brandbook::findOrFail($id)->logo;
                $fn = storage_path( uniqid() . time() . time() . '.svg' );
                file_put_contents( $fn, $svg );
                $this->resize_svg( $fn, 1200, 1200 );
                $svg = file_get_contents( $fn );
                unlink( $fn );

                $pdf = PDF::loadView( 'pdf.asset', [ 'image' => $svg, 'height' => 1200, 'width' => 1200, 'background' => $background, 'radius' => $radius ] )->setOption( 'page-width', 1200 / 58 )->setOption( 'page-height', 1200 / 58 )->setOption( 'margin-top', 0 )->setOption( 'margin-bottom', 0 )->setOption( 'margin-left', 0 )->setOption( 'margin-right', 0 );
                if ( file_exists( storage_path( $path . '.pdf' ) ) )
                    unlink( storage_path( $path . '.pdf' ) );
                $pdf->save( storage_path( $path . '.pdf' ) );
                $list[] = storage_path( $path . '.pdf' );

            } else {
                //normal saving
                $img_px->save( storage_path( $path . '.png' ), 100, 'png' );
                $list[] = storage_path( $path . '.png' );
                $img_px->save( storage_path( $path . '.jpg' ), 100, 'jpg' );
                $list[] = storage_path( $path . '.jpg' );

                // $svg = Brandbook::findOrFail($id)->logo;
                $fn = storage_path( uniqid() . time() . time() . '.svg' );
                file_put_contents( $fn, $svg );
                $this->resize_svg( $fn, $n_width, $n_height );
                $svg = file_get_contents( $fn );
                unlink( $fn );

                $pdf = PDF::loadView( 'pdf.asset', [ 'image' => $svg, 'height' => $n_height, 'width' => $n_width, 'background' => false, 'radius' => false ] )->setOption( 'page-width', $n_width )->setOption( 'page-height', $n_height )->setOption( 'margin-top', 0 )->setOption( 'margin-bottom', 0 )->setOption( 'margin-left', 0 )->setOption( 'margin-right', 0 );
                if ( file_exists( storage_path( $path . '.pdf' ) ) )
                    unlink( storage_path( $path . '.pdf' ) );
                $pdf->save( storage_path( $path . '.pdf' ) );
                $list[] = storage_path( $path . '.pdf' );

            }
        } else {
            //it's not SVG
            unlink( $file );
            if ( strpos( $img->mime(), 'png' ) ) {
                $file   = str_replace( '.svg', '.png', $file );
                $list[] = storage_path( $path . '.png' );
                file_put_contents( $file, $image );

                //normal saving
                $img_px = Image::make( $file );
                $img_px->save( storage_path( $path . '.jpg' ), 100, 'jpg' );
                $list[] = storage_path( $path . '.jpg' );
                $pdf    = PDF::loadView( 'pdf.asset', [ 'image' => '<img src="data:image/png;base64,' . base64_encode( file_get_contents( $file ) ) . '">', 'height' => $n_height, 'width' => $n_width, 'background' => false, 'radius' => false ] )->setOption( 'page-width', $n_width )->setOption( 'page-height', $n_height )->setOption( 'margin-top', 0 )->setOption( 'margin-bottom', 0 )->setOption( 'margin-left', 0 )->setOption( 'margin-right', 0 );
                if ( file_exists( storage_path( $path . '.pdf' ) ) )
                    unlink( storage_path( $path . '.pdf' ) );
                $pdf->save( storage_path( $path . '.pdf' ) );
                $list[] = storage_path( $path . '.pdf' );

            } else {
                $file   = str_replace( '.svg', '.jpg', $file );
                $list[] = storage_path( $path . '.jpg' );
                file_put_contents( $file, $image );
                $img_px = Image::make( $file );
                $img_px->save( storage_path( $path . '.png' ), 100, 'png' );
                $list[] = storage_path( $path . '.png' );
                $pdf    = PDF::loadView( 'pdf.asset', [ 'image' => '<img src="data:image/jpeg;base64,' . base64_encode( file_get_contents( $file ) ) . '">', 'height' => $n_height, 'width' => $n_width, 'background' => false, 'radius' => false ] )->setOption( 'page-width', $n_width )->setOption( 'page-height', $n_height )->setOption( 'margin-top', 0 )->setOption( 'margin-bottom', 0 )->setOption( 'margin-left', 0 )->setOption( 'margin-right', 0 );
                if ( file_exists( storage_path( $path . '.pdf' ) ) )
                    unlink( storage_path( $path . '.pdf' ) );
                $pdf->save( storage_path( $path . '.pdf' ) );
                $list[] = storage_path( $path . '.pdf' );
            }

        }
    }

    public function resize_svg( $file, $h, $w ) {

        try {
            $dom = new \DOMDocument( '1.0', 'utf-8' );
            $dom->load( $file );
            $svg = $dom->documentElement;
            if ( !$svg->hasAttribute( 'viewBox' ) ) { // viewBox is needed to establish
                // userspace coordinates
                $pattern = '/^(\d*\.\d+|\d+)(px)?$/'; // positive number, px unit optional

                $interpretable = preg_match( $pattern, $svg->getAttribute( 'width' ), $width ) &&
                    preg_match( $pattern, $svg->getAttribute( 'height' ), $height );

                if ( $interpretable ) {
                    $view_box = implode( ' ', [ 0, 0, $width[ 0 ], $height[ 0 ] ] );
                    $svg->setAttribute( 'viewBox', $view_box );
                } else { // this gets sticky
                    throw new \Exception( "viewBox is dependent on environment" );
                }
            }

            $svg->setAttribute( 'width', $w );
            $svg->setAttribute( 'height', $h );
            $dom->save( $file );
        } catch ( \Exception $e ) {
        }
    }

    protected function isAdminAction( Brandbook $brandbook ) {
        return Auth::user()->id == $brandbook->user_id && Auth::user()->isAdmin();
    }

    public function pdf_download( Brandbook $brandbook ) {

        if ( !Auth::user()->can_do( 'download', $brandbook ) )
            return redirect()->back();

        return $this->pdf_prepare( $brandbook->id, $brandbook->theme, true );
    }

    public function pdf_prepare( $id, $theme, $spreads = false, $add_theme_to_pdf = false ) {

        $bb       = Brandbook::findOrFail( $id );
        $theme_id = $theme;
        if ( empty( $theme ) )
            $theme = 'gradient';

        if ( intval( $theme ) == 0 && $theme == $bb->theme ) {
            $t        = Theme::where( 'name', $theme )->first();
            $theme_id = $t->id;
            $theme    = json_decode( $t->file, true );
            $theme    = $theme[ 0 ][ 'download_link' ];
        } else {

            $t = Theme::find( $theme );

            if ( !$t ) {
                $t = Theme::active()->first();
            }

            $theme_id = $t->id;
            $theme    = json_decode( $t->file, true );
            $theme    = $theme[ 0 ][ 'download_link' ];
        }

        copy( storage_path( 'app/public/' . $theme ), resource_path( 'views' ) . '/themes/' . str_replace( '.php', '.blade.php', basename( $theme ) ) );

        if ( $spreads ) {
            $html = file_get_contents( resource_path( 'views' ) . '/themes/' . str_replace( '.php', '.blade.php', basename( $theme ) ) );
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
            file_put_contents( resource_path( 'views' ) . '/themes/' . str_replace( '.php', '.blade.php', basename( $theme ) ), $html );
        }

        $theme = 'themes.' . str_replace( '.php', '', basename( $theme ) );

        $bb->colors_list = collect( json_decode( $bb->colors_list ) )/*)*/ ->map( function ( $color, $index ) {
            if ( !isset( $color->show_shades ) )
                $color->show_shades = true;

            if ( !isset( $color->color ) ) {
                return $color;
            }
            if ( isset( $color->color->loaded ) && $color->color->loaded == false ) {
                $data         = json_decode( file_get_contents( "http://www.thecolorapi.com/id?format=json&hex=" . str_replace( '#', '', $color->color->hex->value ) ) );
                $data->loaded = true;
                $color->color = $data;
            }
            $color->color->scheme = json_decode( file_get_contents( 'http://www.thecolorapi.com/scheme?format=json&named=false&hex=' . str_replace( '#', '', $color->color->hex->value ) . '&count=5' ) );
            $hex                  = new HEXValue( str_replace( '#', '', $color->color->hex->value ) );
            $pantoneSolidCoated   = new PANTONESystem(
                PANTONEEnum::PANTONE_PLUS_SOLID_COATED()
            );
            try {
                $pantone        = $pantoneSolidCoated->findColor( $hex, 15 );
                $color->pantone = $pantone->getIterator()->current();
            } catch ( InvalidInputNumberException $e ) {
                $color->pantone = '';
            }
            return $color;
        } )->all();

        $bb->approved = json_decode( $bb->approved );
        $bb->rejected = json_decode( $bb->rejected );

        $bb->approved_icon = json_decode( $bb->approved_icon, true );
        if ( !is_array( $bb->approved_icon ) )
            $bb->approved_icon = [];

        if ( !is_array( $bb->core_values ) )
            $bb->core_values = json_decode( $bb->core_values, true );

        if ( !is_array( $bb->core_values ) || $bb->core_values == null )
            $bb->core_values = [];

        $bb->logo_versions = json_decode( $bb->logo_versions );
        $bb->missuses      = json_decode( $bb->missuses );
        $bb->mockups       = json_decode( $bb->mockups );
        $bb->icon_family   = json_decode( $bb->icon_family, true );
        $if                = [];
        if ( is_array( $bb->icon_family ) )
            foreach ( $bb->icon_family as $i => $item ) {
                $item[ 'icon_b64' ] = base64_encode( file_get_contents( storage_path( 'app/' . $item[ 'icon' ] ) ) );
                $if[ $i ]           = $item;
            }
        $bb->icon_family = $if;

        if ( !is_array( $bb->logo_versions ) )
            $bb->logo_versions = [];
        if ( !is_array( $bb->missuses ) )
            $bb->missuses = [];
        if ( !is_array( $bb->mockups ) )
            $bb->mockups = [];
        if ( !is_array( $bb->approved ) )
            $bb->approved = [];

        $bb->fonts_main      = collect( json_decode( $bb->fonts_main, true ) );
        $bb->fonts_main      = $bb->fonts_main->map( function ( $item ) {

            if ( isset( $item[ 'file' ] ) ) {
                $path = str_replace( '/storage', '/public', $item[ 'file' ] );
                if ( strpos( $item[ 'file' ], 'fonts.gstatic.com' ) == false )
                    $data = file_get_contents( public_path() . $item[ 'file' ] );
                else
                    $data = file_get_contents( $item[ 'file' ] );
                $item[ 'font' ] = 'data:font/truetype;charset=utf-8;base64,' . base64_encode( $data );
                return $item;
            }
        } );

        $bb->fonts_secondary = collect( json_decode( $bb->fonts_secondary, true ) );
        $bb->fonts_secondary = $bb->fonts_secondary->map( function ( $item ) {

            if ( isset( $item[ 'file' ] ) ) {
                $path = str_replace( '/storage', '/public', $item[ 'file' ] );
                if ( strpos( $item[ 'file' ], 'fonts.gstatic.com' ) == false )
                    $data = file_get_contents( public_path() . $item[ 'file' ] );
                else
                    $data = file_get_contents( $item[ 'file' ] );
                $item[ 'font' ] = 'data:font/truetype;charset=utf-8;base64,' . base64_encode( $data );
                return $item;
            }
        } );

        $icon   = $this->get_image_dimensions( $bb->icon );
        $logo_d = $this->get_image_dimensions( $bb->logo );

        $bb->logo_w = $logo_d[ 'w' ];
        $bb->logo_h = $logo_d[ 'h' ];

        $all_logos = [];
        $all_icons = [];
        if ( !empty( $bb->all_logo_variations ) ) {
            foreach ( json_decode( $bb->all_logo_variations, true ) as $all_logo_variation ) {
                $all_logos[ $all_logo_variation[ 'id' ] ] = $all_logo_variation;
            }
        }

        if ( !empty( $bb->all_icon_variations ) ) {
            foreach ( json_decode( $bb->all_icon_variations, true ) as $all_icon_variation ) {
                $all_icons[ $all_icon_variation[ 'id' ] ] = $all_icon_variation;
            }
        }

        $bb->all_icon_variations = $all_icons;
        $bb->all_logo_variations = $all_logos;

        try {
            $ext = pathinfo( $bb->user->avatar, PATHINFO_EXTENSION );
            if ( strpos( $bb->user->avatar, 'http' ) === false ) {
                $bb->user->avatar = "data:image/{$ext};base64," . base64_encode( \File::get( public_path( $bb->user->avatar ) ) );
            } else {
                $bb->user->avatar = $bb->user->avatar;
            }

        } catch ( \Exception $e ) {
            info( 'Avatar not found at path' . $bb->user->avatar );
            $bb->user->avatar = "data:image/png;base64," . base64_encode( \File::get( public_path( 'users/default.png' ) ) );
        }

        if ( $spreads ) {
            $pdf  = PDF::loadView( $theme, [
                'data'   => $bb, 'icon_w' => $icon[ 'w' ],
                'icon_h' => $icon[ 'h' ]
            ] )->setOption( 'page-width', '1168px' )->setOption( 'page-height', '584px' )/*->setOption('no-outline', true)*/ ->setOption( 'margin-top', 0 )->setOption( 'margin-bottom', 0 )->setOption( 'margin-left', 0 )->setOption( 'margin-right', 0 );//->setOption('lowquality', 1);//setOptions(['dpi'=>300])->setPaper([0,0,840,840])->
            $file = '/storage/user_files/' . $bb->user->id . '/' . time() . '-spread.pdf';
            $pdf->setOption( 'encoding', 'utf-8' );
            $pdf->save( public_path() . $file );
            return $pdf->download( basename( $file ) );//download
        } else {
            $pdf  = PDF::loadView( $theme, [
                'data'   => $bb, 'icon_w' => $icon[ 'w' ],
                'icon_h' => $icon[ 'h' ]
            ] )->setOption( 'page-width', '560px' )->setOption( 'page-height', '560px' )/*->setOption('no-outline', true)*/ ->setOption( 'margin-top', 0 )->setOption( 'margin-bottom', 0 )->setOption( 'margin-left', 0 )->setOption( 'margin-right', 0 );//->setOption('lowquality', 1);//setOptions(['dpi'=>300])->setPaper([0,0,840,840])->
            $file = '/storage/user_files/' . $bb->user->id . '/' . $theme_id . '-' . time() . '.pdf';
            $pdf->setOption( 'encoding', 'utf-8' );
            $pdf->save( public_path() . $file );
        }

        unset( $bb->icon_w );
        unset( $bb->icon_h );

        Brandbook::where( 'id', $bb->id )->update( [ 'pdf_link' => json_encode( [ $bb->theme => $file ] ) ] );
        if ( $spreads ) {
            return $pdf->inline( $bb->id . '.pdf' );
        } else {
            return $file;
        }
    }

    public function generate_pdf( Request $request ) {

        if ( Auth::check() ) {
            $bb        = Brandbook::findOrFail( $request->id );
            $bb->theme = $request->theme;
            $bb->save();

            //remove brandbook preview to request image regeneration
            if ( file_exists( storage_path( 'previews/' . $bb->id . '.jpg' ) ) )
                unlink( storage_path( 'previews/' . $bb->id . '.jpg' ) );


            if ( $request->has( 'all' ) ) {
                $themes = Theme::where( 'is_active', true )->get();
                $pdfs   = [];
                foreach ( $themes as $theme ) {
                    $pdfs[ $theme->id ] = $this->pdf_prepare( $request->id, $theme->id, false, true );
                }
                Brandbook::where( 'id', $bb->id )->update( [ 'pdf_link' => json_encode( $pdfs ) ] );

                Mail::to($bb->user->email)
                    ->bcc(config('mail.bcc'))
                    ->send((new BrandbookIsReady($bb)));

                return response()->json( $pdfs );
            } else {
                return $this->pdf_prepare( $request->id, $request->theme );
            }
        }
    }

    protected function generatePDF( Brandbook $brandbook ) {
        //remove brandbook preview to request image regeneration
        if ( file_exists( storage_path( 'previews/' . $brandbook->id . '.jpg' ) ) ) {
            unlink( storage_path( 'previews/' . $brandbook->id . '.jpg' ) );
        }

        $themes = Theme::where( 'is_active', true )->get();
        $pdfs   = [];

        foreach ( $themes as $theme ) {
            $pdfs[ $theme->id ] = $this->pdf_prepare( $brandbook->id, $theme->id, false, true );
        }

        return $pdfs;
    }

    public function save_field( Request $request ) {

        if ( Auth::check() ) {
            $bb         = Brandbook::findOrFail( $request->id );
            $field      = $request->field;
            $bb->$field = $request->text;
            $bb->save();
            return response( ':)', 200 );
        }
    }

    public function embed( string $link ) {

        $bb = Brandbook::where( 'shared_link', $link )->firstOrFail();
        return view( 'js.embed', [ 'url' => str_replace( '8000', '3000', route( 'brandbook.embed.view', $link ) ) ] );
    }

    public function embed_view( string $link ) {

        $bb = Brandbook::where( 'shared_link', $link )->firstOrFail();
        return view( 'brandbook.embed', [ 'data' => $bb ] );
    }

    public function shared( string $link ) {

        $bb  = Brandbook::where( 'shared_link', $link )->firstOrFail();
        $url = route( 'brandbook.my' ) . '/view/' . $bb->id;
        session( [ 'url.ginger.shared' => $url ] );
        session( [ 'bb.shared.id' => $bb->id ] );
        return redirect( $url );
    }

    public function list_item( Request $request ) {

        if ( Auth::check() ) {
            $b = Brandbook::findOrFail( $request->id );
            return response( View::make( 'parts.brandbookitem' )->with( [ 'brandbook' => $b ] )->render() );
        }
    }

    /**
     * Proxyfies request to colormind API to generate the color scheme
     * @param Request $request details of the request POST
     * @return Response JSON response with color scheme
     */
    public function colormind( Request $request ) {

        $ch   = curl_init();
        $data = $request->json()->all();

        curl_setopt( $ch, CURLOPT_URL, 'http://colormind.io/api/' );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $ch, CURLOPT_POST, 1 );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $data ) );
        curl_setopt( $ch, CURLOPT_TIMEOUT, 5 );

        $headers   = [];
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );

        $result = curl_exec( $ch );


        if ( curl_errno( $ch ) ) {
            $data[ 'input' ][ 0 ] = $data[ 'input' ][ 1 ];
            $data[ 'input' ][ 3 ] = $data[ 'input' ][ 1 ];
            $data[ 'input' ][ 4 ] = $data[ 'input' ][ 1 ];
            $result               = [ 'result' => $data[ 'input' ] ];
        } else {
            $result = json_decode( $result, true );
        }

        curl_close( $ch );

        $response = [];

        foreach ( $result[ 'result' ] as $index => $color ) {
            $title       = '';
            $name        = '';
            $description = '';
            $locked      = false;
            switch ( $index ) {
                case 4:
                    $name        = __( 'Light shades' );
                    $description = __( 'Use this color as the background for your dark-on-light designs, or the text color of an inverted design.' );
                    break;
                case 3:
                    $title       = __( 'Tertiary Color' );
                    $name        = __( 'Light accent' );
                    $description = __( 'Accent colors can be user to bring attention to design elements be contrasting with the rest of the palette.' );

                    break;
                case 2:
                    $title = __( 'Primary Color' );
                    //$locked=true;
                    $name        = __( 'Main brand color' );
                    $description = __( 'This color shoul be eye-catching but not harsh. It can be liberally applied to your layout as its main identity.' );
                    break;
                case 1:
                    $title = __( 'Secondary Color' );
                    $name  = __( 'Dark accent' );
                    //$locked=true;
                    $description = __( 'Another accent color to consider. Not all colors have to be used – sometimes a simple color scheme works best.' );
                    break;
                case 0:
                    $name        = __( 'Dark shades' );
                    $description = __( 'Use as the text color for dark-on-light designs, or as the background for inverted designs.' );
                    break;
            }
            $block      = [
                'color'  => [
                    'hex'         => sprintf( "#%02x%02x%02x", $color[ 0 ], $color[ 1 ], $color[ 2 ] ),
                    'rgb'         => 'rgb(' . join( ',', $color ) . ')',
                    'name'        => $name,
                    'description' => $description
                ],
                'title'  => $title,
                'locked' => $locked
            ];
            $response[] = $block;
        }

        return response()->json( $response, 200 );
    }

    public function admin_files( Brandbook $brandbook ) {

        $files = [];
        $id    = $brandbook->id;
        if ( !file_exists( storage_path( 'bbassets-admin/' ) ) )
            mkdir( storage_path( 'bbassets-admin/' ) );
        if ( !file_exists( storage_path( 'bbassets-admin/' . $id ) ) )
            mkdir( storage_path( 'bbassets-admin/' . $id ) );
        if ( !empty( $brandbook->logo ) ) {
            $path = 'logo';
            $name = 'logo';
            if ( !file_exists( storage_path( 'bbassets-admin/' . $id . '/' . $path ) ) )
                mkdir( storage_path( 'bbassets-admin/' . $id . '/' . $path ) );
            $path = 'bbassets-admin/' . $id . '/' . $path . '/' . $name;
            $file = storage_path( $path . '.svg' );
            file_put_contents( $file, $brandbook->logo );
            $files[] = $file;
        }
        if ( !empty( $brandbook->approved ) ) {
            $path_ = 'logo-versions';
            if ( !file_exists( storage_path( 'bbassets-admin/' . $id . '/' . $path_ ) ) )
                mkdir( storage_path( 'bbassets-admin/' . $id . '/' . $path_ ) );
            foreach ( json_decode( $brandbook->approved, true ) as $c => $logo_v ) {
                $name = 'logo-version-' . $c;
                $path = 'bbassets-admin/' . $id . '/' . $path_ . '/' . $name;
                $file = storage_path( $path . '.svg' );
                file_put_contents( $file, $logo_v[ 'logo' ] );
                $files[] = $file;
            }
        }


        if ( !empty( $brandbook->icon ) && $brandbook->icon != 'skipped' ) {
            $path = 'brand-icon';
            $name = 'brand-icon';
            if ( !file_exists( storage_path( 'bbassets-admin/' . $id . '/' . $path ) ) )
                mkdir( storage_path( 'bbassets-admin/' . $id . '/' . $path ) );
            $path = 'bbassets-admin/' . $id . '/' . $path . '/' . $name;
            $file = storage_path( $path . '.svg' );
            file_put_contents( $file, $brandbook->icon );
            $files[] = $file;
        }

        if ( !empty( $brandbook->approved_icon ) ) {
            $path_ = 'icon-versions';
            if ( !file_exists( storage_path( 'bbassets-admin/' . $id . '/' . $path_ ) ) )
                mkdir( storage_path( 'bbassets-admin/' . $id . '/' . $path_ ) );
            foreach ( json_decode( $brandbook->approved_icon, true ) as $i => $icon_v ) {
                if ( $icon_v[ 'icon' ] !== 'skipped' ) {
                    $name = 'icon-' . $i;
                    $path = 'bbassets-admin/' . $id . '/' . $path_ . '/' . $name;
                    $file = storage_path( $path . '.svg' );
                    file_put_contents( $file, $icon_v[ 'icon' ] );
                    $files[] = $file;
                }
            }
        }

        if ( !empty( $brandbook->core_values ) ) {
            $path_ = 'core-values';
            if ( !file_exists( storage_path( 'bbassets-admin/' . $id . '/' . $path_ ) ) )
                mkdir( storage_path( 'bbassets-admin/' . $id . '/' . $path_ ) );
            foreach ( json_decode( $brandbook->core_values, true ) as $i => $core_v ) {
                if ( !empty( $core_v[ 'url' ] ) ) {
                    $name = 'icon_' . $i;
                    $path = 'bbassets-admin/' . $id . '/' . $path_ . '/' . $name;
                    $file = storage_path( $path . '.svg' );
                    file_put_contents( $file, file_get_contents( storage_path( 'app/' . $core_v[ 'url' ] ) ) );
                    $files[] = $file;
                }
            }
        }
        if ( !empty( $brandbook->icon_family ) ) {
            $path_ = 'icon-family';
            if ( !file_exists( storage_path( 'bbassets-admin/' . $id . '/' . $path_ ) ) )
                mkdir( storage_path( 'bbassets-admin/' . $id . '/' . $path_ ) );
            foreach ( json_decode( $brandbook->icon_family, true ) as $i => $core_v ) {
                if ( !empty( $core_v[ 'icon' ] ) ) {
                    $name = 'icon_' . $i;
                    $path = 'bbassets-admin/' . $id . '/' . $path_ . '/' . $name;
                    $file = storage_path( $path . '.svg' );
                    file_put_contents( $file, file_get_contents( storage_path( 'app/' . $core_v[ 'icon' ] ) ) );
                    $files[] = $file;
                }
            }
        }
        if ( !empty( $brandbook->fonts_main ) ) {
            $path_ = 'fonts-main';
            if ( !file_exists( storage_path( 'bbassets-admin/' . $id . '/' . $path_ ) ) )
                mkdir( storage_path( 'bbassets-admin/' . $id . '/' . $path_ ) );
            foreach ( json_decode( $brandbook->fonts_main, true ) as $i => $font ) {
                if ( !is_null( $font ) && !empty( $font[ 'file' ] ) && !preg_match( '/gstatic/', $font[ 'file' ] ) ) {
                    $name = 'font_' . $i;
                    $path = 'bbassets-admin/' . $id . '/' . $path_ . '/' . $name;
                    $file = storage_path( $path . '.' . pathinfo( $font[ 'file' ], PATHINFO_EXTENSION ) );
                    file_put_contents( $file, file_get_contents( storage_path( str_replace( 'storage/', 'app/public/', $font[ 'file' ] ) ) ) );
                    $files[] = $file;
                }
            }
        }
        if ( !empty( $brandbook->fonts_secondary ) ) {
            $path_ = 'fonts-secondary';
            if ( !file_exists( storage_path( 'bbassets-admin/' . $id . '/' . $path_ ) ) )
                mkdir( storage_path( 'bbassets-admin/' . $id . '/' . $path_ ) );
            foreach ( json_decode( $brandbook->fonts_secondary, true ) as $i => $font ) {
                if ( !is_null( $font ) && !empty( $font[ 'file' ] ) && !preg_match( '/gstatic/', $font[ 'file' ] ) ) {
                    $name = 'font_' . $i;
                    $path = 'bbassets-admin/' . $id . '/' . $path_ . '/' . $name;
                    $file = storage_path( $path . '.' . pathinfo( $font[ 'file' ], PATHINFO_EXTENSION ) );
                    file_put_contents( $file, file_get_contents( storage_path( str_replace( 'storage/', 'app/public/', $font[ 'file' ] ) ) ) );
                    $files[] = $file;
                }
            }
        }
        if ( !empty( $brandbook->mockups ) ) {
            $path_ = 'mockups';
            if ( !file_exists( storage_path( 'bbassets-admin/' . $id . '/' . $path_ ) ) )
                mkdir( storage_path( 'bbassets-admin/' . $id . '/' . $path_ ) );
            foreach ( json_decode( $brandbook->mockups, true ) as $i => $mockup ) {
                if ( !is_null( $mockup ) && !empty( $mockup[ 'url' ] ) ) {
                    $name = 'mockup_' . $i;
                    $path = 'bbassets-admin/' . $id . '/' . $path_ . '/' . $name;
                    $file = storage_path( $path . '.' . pathinfo( $mockup[ 'url' ], PATHINFO_EXTENSION ) );
                    file_put_contents( $file, file_get_contents( storage_path( 'app/' . $mockup[ 'url' ] ) ) );
                    $files[] = $file;
                }
            }
        }

        if ( isset( $brandbook->theme ) && isset( $brandbook->pdf_link ) && !empty( $brandbook->theme ) && $brandbook->theme != null && $brandbook->pdf_link != null && !empty( $brandbook->pdf_link ) ) {
            $file = $this->adminPDF( $brandbook );
            file_put_contents( storage_path() . '/pdf-spread-' . $brandbook->id . '.pdf', $file );
            $files[] = storage_path() . '/pdf-spread-' . $brandbook->id . '.pdf';
        }

        $archiveFile     = storage_path( "bbassets-admin/{$brandbook->id}-assets.zip" );
        $relative_path   = storage_path( "bbassets-admin/{$brandbook->id}/" );
        $relative_path_2 = storage_path( '/app/public/user_files/' . $brandbook->user_id . '/' );
        $relative_path_3 = storage_path() . '/';
        $archive         = new \ZipArchive();
        if ( $archive->open( $archiveFile, \ZipArchive::CREATE | \ZipArchive::OVERWRITE ) ) {
            $archive->addEmptyDir( 'logo' );
            $archive->addEmptyDir( 'brand-icon' );
            $archive->addEmptyDir( 'icon-versions' );
            $archive->addEmptyDir( 'core-values' );
            $archive->addEmptyDir( 'icon-family' );
            $archive->addEmptyDir( 'fonts-main' );
            $archive->addEmptyDir( 'fonts-secondary' );
            $archive->addEmptyDir( 'mockups' );
            // Loop through all the files and add them to the archive.
            foreach ( $files as $file ) {
                if ( $archive->addFile( $file, str_replace( $relative_path_3, '', str_replace( $relative_path_2, '', str_replace( $relative_path, '', $file ) ) ) ) ) {
                    // Do something here if addFile succeeded, otherwise this statement is unnecessary and can be ignored.
                    continue;
                } else {
                    throw new \Exception( "File [`{$file}`] could not be added to the zip file: " . $archive->getStatusString() );
                }
            }

            // Close the archive.
            if ( $archive->close() ) {
                // Archive is now downloadable ...
                return response()->download( $archiveFile, basename( $archiveFile ) )->deleteFileAfterSend( true );
            } else {
                throw new \Exception( "Could not close zip file: " . $archive->getStatusString() );
            }
        } else {
            throw new \Exception( "Zip file could not be created: " . $archive->getStatusString() );
        }
    }

    protected function adminPDF( Brandbook $brandbook ) {

        return $this->pdf_prepare( $brandbook->id, $brandbook->theme, true );
    }

    public function pdf_preview( Brandbook $brandbook ) {

        // if($brandbook->completed > 28){
        if ( isset( $brandbook->theme ) && isset( $brandbook->pdf_link ) && !empty( $brandbook->theme ) && $brandbook->theme != null && $brandbook->pdf_link != null && !empty( $brandbook->pdf_link ) ) {
            /*if(file_exists(storage_path('previews/'.$brandbook->id.'.jpg'))){
                    $im = new \Imagick();
                    $im->readImage(storage_path('previews/'.$brandbook->id.'.jpg'));
                    $im->setImageFormat('jpg');
                    header('Content-Type: image/jpeg');
                    echo $im;
                }else*/ {
                $im = new \Imagick();
                $im->setResolution( 72, 72 );     //set the resolution of the resulting jpg

                $bb_pdf_link = json_decode( $brandbook->pdf_link, true );

                // $pdf_link_path = isset( $bb_pdf_link[ $brandbook->theme ] ) ?
                //     $bb_pdf_link[ $brandbook->theme ] :
                //     end($bb_pdf_link);

                // $pdf_link = storage_path( str_replace( 'storage/', 'app/public/', $pdf_link_path ) );

                if ( isset( $bb_pdf_link[ $brandbook->theme ] ) ) {
                    $pdf_link = storage_path( str_replace( 'storage/', 'app/public/', $bb_pdf_link[ $brandbook->theme ] ) );
                } elseif ( count( $bb_pdf_link ) ) {
                    $last     = end( $bb_pdf_link );
                    $pdf_link = storage_path( str_replace( 'storage/', 'app/public/', $last ) );
                }

                if ( !isset( $pdf_link ) || !file_exists( $pdf_link ) ) {
                    return null;
                }

                $im->readImage( $pdf_link . '[0]' );    //[0] for the first page
                $im->setImageFormat( 'jpg' );
                if ( !file_exists( storage_path( 'previews/' ) ) )
                    mkdir( storage_path( 'previews/' ) );
                file_put_contents( storage_path( 'previews/' . $brandbook->id . '.jpg' ), $im );
                header( 'Content-Type: image/jpeg' );
                echo $im;
            }
            // $file = $this->pdf_download($brandbook);
            // file_put_contents(storage_path().'/pdf-spread-'.$brandbook->id.'.pdf', $file);
            // $files[] = storage_path().'/pdf-spread-'.$brandbook->id.'.pdf';
        }
        // }
    }

}
