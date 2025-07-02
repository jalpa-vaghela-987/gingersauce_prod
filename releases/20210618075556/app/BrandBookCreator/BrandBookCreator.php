<?php


namespace App\BrandBookCreator;


use App\Brandbook;
use Color\System\Enum\PANTONE as PANTONEEnum;
use Color\System\PANTONE as PANTONESystem;
use Color\Value\HEX as HEXValue;
use Intervention\Image\ImageManagerStatic as Image;

class BrandBookCreator{

    /**
     * @var Brandbook
     */
    protected $brandBook;
    protected $load;

    /**
     * publix properies
     */

    public $colors_list;
    public $approved;
    public $rejected;
    public $approved_icon;
    public $core_values;
    public $all_icons;
    public $all_logos;
    public $pdf_link;
    public $logo_w;
    public $logo_h;
    public $icon_w;
    public $icon_h;
    public $fonts_secondary;
    public $logo_versions;
    public $fonts_main;
    public $icon_family;
    public $mockups;
    public $missuses;
    public $brand;
    public $logo;
    public $logo_b64;
    public $icon;
    public $icon_b64;
    public $custom_logo;
    public $custom;
    public $proportions;
    public $space;
    public $size;
    public $color_scheme_mode;
    public $generated_colors;
    public $colors_used;
    public $vision;
    public $mission;
    public $proportions_icon;

    public $user;


    public $approved_primary_color   = false;
    public $approved_secondary_color = false;
    public $main_color;
    public $secondary_color;
    public $tertiary_color;
    public $color_class;


    public function __construct( Brandbook $brandbook, $load = false ){

        $this->brandBook = $brandbook;
        $this->load      = $load;
        $this->prepare();
    }

    protected function prepare(){

        $this->setColorlist( $this->load );
        $this->setApproved();
        $this->setRejected();
        $this->approvedIcon();
        $this->coreValues();
        $this->logoVersions();
        $this->missuses();
        $this->mockups();
        $this->iconFamily();
        $this->fontsMain();
        $this->fontsSecondary();
        $this->logoSizes();
        $this->iconSizes();
        $this->pdfLinks();
        $this->allLogoVariations();
        $this->allIconVariations();
        $this->copyProperties();
    }

    protected function copyProperties(){

        $this->brand             = $this->brandBook->brand;
        $this->logo              = $this->brandBook->logo;
        $this->logo_b64          = $this->brandBook->logo_b64;
        $this->icon              = $this->brandBook->icon;
        $this->icon_b64          = $this->brandBook->icon_b64;
        $this->custom_logo       = $this->brandBook->custom_logo;
        $this->custom            = $this->brandBook->custom;
        $this->proportions       = $this->brandBook->proportions;
        $this->space             = $this->brandBook->space;
        $this->size              = $this->brandBook->size;
        $this->color_scheme_mode = $this->brandBook->color_scheme_mode;
        $this->generated_colors  = $this->brandBook->generated_colors;
        $this->colors_used       = $this->brandBook->colors_used;
        $this->vision            = $this->brandBook->vision;
        $this->mission           = $this->brandBook->mission;
        $this->user = $this->brandBook->user;
    }

    protected function get_image_dimensions( $image ){

        if ( !empty( $image ) && $image != 'skipped' && $image != '[]' ){
            $fn = storage_path( time() . uniqid() . '.svg' );
            file_put_contents( $fn, $image );
            Image::configure( [ 'driver' => 'imagick' ] );
            $img = Image::make( $fn );
            $w   = $img->width();
            $h   = $img->height();
            unlink( $fn );
            return [ 'w' => $w, 'h' => $h ];
        } else{
            return [ 'w' => 50, 'h' => 50 ];
        }
    }

    protected function setColorlist( $load ){

        $this->colors_list = collect( json_decode( $this->brandBook->colors_list ) )->map( function ( $color ) use ( $load ){

            if ( !isset( $color->color ) ){
                $clr                      = $color;
                $color                    = new \stdClass;
                $color->color             = new \stdClass;
                $color->color->loaded     = false;
                $color->color->hex        = new \stdClass;
                $color->color->hex->value = $clr;
            }

            if ( $load ){
                if ( isset( $color->color ) && isset( $color->color->loaded ) && $color->color->loaded == false ){
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
            try{
                $pantone        = $pantoneSolidCoated->findColor( $hex, 15 );
                $color->pantone = $pantone->getIterator()->current();
            } catch ( Exception $e ){

            }
            return $color;
        } )->all();
    }

    public function setRejected(){

        $this->rejected = json_decode( $this->brandBook->rejected );
    }

    public function setApproved(){

        $this->approved = json_decode( $this->brandBook->approved );
        if ( !is_array( $this->approved ) ){
            $this->approved = [];
        }
    }

    public function approvedIcon(){

        $this->approved_icon = json_decode( $this->brandBook->approved_icon, true );
        if ( !is_array( $this->brandBook->approved_icon ) ){
            $this->approved_icon = [];
        }
    }

    public function coreValues(){

        if ( !is_array( $this->brandBook->core_values ) ){
            $this->core_values = json_decode( $this->brandBook->core_values, true );
        }

        if ( !is_array( $this->brandBook->core_values ) || $this->brandBook->core_values == null ){
            $this->core_values = [];
        }
    }

    public function logoVersions(){

        $logo_versions = json_decode( $this->brandBook->logo_versions );

        if ( !is_array( $logo_versions ) ){
            $this->logo_versions = [];
        }
    }

    public function missuses(){

        $this->missuses = json_decode( $this->brandBook->missuses );
        if ( !is_array( $this->missuses ) ){
            $this->missuses = [];
        }
    }

    public function mockups(){

        $mockups = json_decode( $this->brandBook->mockups );
        if ( !is_array( $mockups ) ){
            $this->mockups = [];
        }
    }


    public function iconFamily(){

        $icon_family = json_decode( $this->brandBook->icon_family, true );
        $if          = [];
        if ( is_array( $icon_family ) ){
            foreach ( $icon_family as $i => $item ){
                $item[ 'icon_b64' ] = base64_encode( file_get_contents( storage_path( 'app/' . $item[ 'icon' ] ) ) );
                $if[ $i ]           = $item;
            }
        }
        $this->icon_family = $if;
    }

    public function fontsMain(){

        $fonts_main       = collect( json_decode( $this->brandBook->fonts_main, true ) );
        $this->fonts_main = $fonts_main->map( function ( $item ){

            if ( isset( $item[ 'file' ] ) ){
                $path = str_replace( '/storage', '/public', $item[ 'file' ] );
                if ( strpos( $item[ 'file' ], 'fonts.gstatic.com' ) == false )
                    $data = file_get_contents( public_path() . $item[ 'file' ] );
                else
                    $data = file_get_contents( $item[ 'file' ] );
                $item[ 'font' ] = 'data:font/truetype;charset=utf-8;base64,' . base64_encode( $data );
                return $item;
            }
        } );
    }

    public function fontsSecondary(){

        $fonts_secondary       = collect( json_decode( $this->brandBook->fonts_secondary, true ) );
        $this->fonts_secondary = $fonts_secondary->map( function ( $item ){

            if ( isset( $item[ 'file' ] ) ){
                $path = str_replace( '/storage', '/public', $item[ 'file' ] );
                if ( strpos( $item[ 'file' ], 'fonts.gstatic.com' ) == false )
                    $data = file_get_contents( public_path() . $item[ 'file' ] );
                else
                    $data = file_get_contents( $item[ 'file' ] );
                $item[ 'font' ] = 'data:font/truetype;charset=utf-8;base64,' . base64_encode( $data );
                return $item;
            }
        } );
    }

    public function logoSizes(){

        $logo_d       = $this->get_image_dimensions( $this->brandBook->logo );
        $this->logo_w = $logo_d[ 'w' ];
        $this->logo_h = $logo_d[ 'h' ];
    }

    public function iconSizes(){

        $icon_d       = $this->get_image_dimensions( $this->brandBook->icon );
        $this->icon_w = $icon_d[ 'w' ];
        $this->icon_h = $icon_d[ 'h' ];
    }

    public function pdfLinks(){

        $bb_pdf_link = json_decode( $this->brandBook->pdf_link, true );

        if ( isset( $bb_pdf_link[ $this->brandBook->theme ] ) ){
            $this->pdf_link = $bb_pdf_link[ $this->brandBook->theme ];
        }
    }

    public function allLogoVariations(){

        $all_logos = [];
        if ( !empty( $this->brandBook->all_logo_variations ) ){
            foreach ( json_decode( $this->brandBook->all_logo_variations, true ) as $all_logo_variation ){
                $all_logos[ $all_logo_variation[ 'id' ] ] = $all_logo_variation;
            }
        }

        $this->all_logos = $all_logos;
    }

    public function allIconVariations(){

        $all_icons = [];

        if ( !empty( $this->brandBook->all_icon_variations ) ){
            foreach ( json_decode( $this->brandBook->all_icon_variations, true ) as $all_icon_variation ){
                $all_icons[ $all_icon_variation[ 'id' ] ] = $all_icon_variation;
            }
        }

        $this->all_icons = $all_icons;
    }

    public function setColors(){

        $this->main_color      = !empty( $this->colors_list[ 0 ]->id ) ? $this->colors_list[ 0 ]->id : '#fff';
        $this->secondary_color = !empty( $this->colors_list[ 1 ]->id ) ? $this->colors_list[ 1 ]->id : '#fff';
        $this->tertiary_color  = !empty( $this->colors_list[ 2 ]->id ) ? $this->colors_list[ 2 ]->id : '#fff';
        $this->color_class     = 'light';

        foreach ( $this->approved as $approved ){
            if ( !empty( $approved->title ) && $approved->title == 'Primary Color Positive' ){
                $this->approved_primary_color = true;
            }

            if ( !empty( $approved->title ) && $approved->title == 'Secondary Color Positive' ){
                $this->approved_secondary_color = true;
            }
        }
    }



}
