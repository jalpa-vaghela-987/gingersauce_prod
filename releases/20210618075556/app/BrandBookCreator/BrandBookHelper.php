<?php


namespace App\BrandBookCreator;


use App\Brandbook;
use phpDocumentor\Reflection\Types\Self_;

class BrandBookHelper {

    const LOGOS_PAGED_TYPE_PRIMARY = 'primary';
    const LOGOS_PAGED_TYPE_BLACK   = 'black';
    const LOGOS_PAGED_TYPE_OTHER   = 'other';


    const ICON_SIZES
        = [
            'quark'    => 10,
            'neutron'  => 14,
            'atom'     => 22,
            'molecule' => 30
        ];

    const LOGO_SIZES
        = [
            'quark'    => 71,
            'neutron'  => 100,
            'atom'     => 160,
            'molecule' => 214
        ];

    const COLOR_NAME_LIST
        = [
            0 => 'primary_color',
            1 => 'secondary_color',
            2 => 'tertiary_color'
        ];

    const ALL_ICON_VARIATIONS_LIST
        = [
            'White Negative on Primary in Square',
            'White Negative on Primary in Circle',
            'White Negative on Secondary in Square',
            'White Negative on Secondary in Circle',
            'White & Colors on Secondary in Square',
            'White & Colors on Secondary in Circle'
        ];

    const BLACK_ICON_VARIATION   = 'Black & White Positive';
    const PRIMARY_ICON_VARIATION = 'Primary Color Positive';

    const PAGED_LOGOS
        = [
            'black'   => [
                '0_White Negative',
                '1_White Negative',
                '2_White Negative',
                '0_White & Colors',
                '1_White & Colors',
                '2_White & Colors',
                '0_Positive on Black',
                '1_Positive on Black',
                '2_Positive on Black',
            ],
            'primary' => [
                '0_White Negative on Primary',
                '1_White Negative on Primary',
                '2_White Negative on Primary',
            ],
            'other'   => [
                '0_Primary Color Positive',
                '0_Primary & Colors',
                '0_Primary & Black',
                '0_Secondary Color Positive',
                '0_Secondary & Colors',
                '0_Secondary & Black',
                '0_Black & White Negative',
                '0_Primary Color Negative',
                '0_Secondary Color Negative',
                '0_White & Black',
                '0_Black & White Positive',
                '1_Primary Color Positive',
                '1_Primary & Colors',
                '1_Primary & Black',
                '1_Secondary Color Positive',
                '1_Secondary & Colors',
                '1_Secondary & Black',
                '1_Black & White Negative',
                '1_Primary Color Negative',
                '1_Secondary Color Negative',
                '1_White & Black',
                '1_Black & White Positive',
                '2_Primary Color Positive',
                '2_Primary & Colors',
                '2_Primary & Black',
                '2_Secondary Color Positive',
                '2_Secondary & Colors',
                '2_Secondary & Black',
                '2_Black & White Negative',
                '2_Primary Color Negative',
                '2_Secondary Color Negative',
                '2_Black & White Positive',
            ]
        ];

    const LOGO_VARIATIONS_ORDER
        = [
            0  => 'alt1',
            1  => '0_White Negative on Primary',
            2  => 'alt2',
            3  => '1_White Negative on Primary',
            4  => '2_White Negative on Primary',
            5  => '0_Primary Color Positive',
            6  => '0_Primary & Colors',
            7  => '0_Primary & Black',
            8  => '0_White Negative',
            9  => '0_Secondary Color Positive',
            10 => '0_Secondary & Colors',
            11 => '0_White & Colors',
            12 => '0_Secondary & Black',
            13 => '0_Black & White Negative',
            14 => '0_Primary Color Negative',
            15 => '0_Secondary Color Negative',
            16 => '0_White & Black',
            17 => '0_Black & White Positive',
            44 => '0_Positive on Black',
            18 => '1_Primary Color Positive',
            19 => '1_Primary & Colors',
            20 => '1_Primary & Black',
            21 => '1_White Negative',
            22 => '1_Secondary Color Positive',
            23 => '1_Secondary & Colors',
            24 => '1_White & Colors',
            25 => '1_Secondary & Black',
            26 => '1_Black & White Negative',
            27 => '1_Primary Color Negative',
            28 => '1_Secondary Color Negative',
            29 => '1_White & Black',
            30 => '1_Black & White Positive',
            45 => '1_Positive on Black',
            31 => '2_Primary Color Positive',
            32 => '2_Primary & Colors',
            33 => '2_Primary & Black',
            34 => '2_White Negative',
            35 => '2_Secondary Color Positive',
            36 => '2_Secondary & Colors',
            37 => '2_White & Colors',
            38 => '2_Secondary & Black',
            39 => '2_Black & White Negative',
            40 => '2_Primary Color Negative',
            41 => '2_Secondary Color Negative',
            42 => '2_White & Black',
            43 => '2_Black & White Positive',
            46 => '2_Positive on Black',
        ];

    const LOGO_BACKGROUND
        = [
            '0_Primary & Black'          => 'C7C7C7',
            '0_Secondary & Black'        => 'C7C7C7',
            '0_White & Black'            => 'C7C7C7',
            '1_Primary & Black'          => 'C7C7C7',
            '1_Secondary & Black'        => 'C7C7C7',
            '1_White & Black'            => 'C7C7C7',
            '2_Primary & Black'          => 'C7C7C7',
            '2_Secondary & Black'        => 'C7C7C7',
            '2_White & Black'            => 'C7C7C7',
            '0_Primary Color Positive'   => 'white',
            '0_Secondary Color Positive' => 'white',
            '0_Black & White Positive'   => 'white',
            '0_Primary Color Negative'   => 'white',
            '0_Secondary Color Negative' => 'white',
            '0_Black & White Negative'   => 'white',
            '0_Primary & Colors'         => 'white',
            '0_Secondary & Colors'       => 'white',
            '1_Primary Color Positive'   => 'white',
            '1_Secondary Color Positive' => 'white',
            '1_Black & White Positive'   => 'white',
            '1_Primary Color Negative'   => 'white',
            '1_Secondary Color Negative' => 'white',
            '1_Black & White Negative'   => 'white',
            '1_Primary & Colors'         => 'white',
            '1_Secondary & Colors'       => 'white',
            '2_Primary Color Positive'   => 'white',
            '2_Secondary Color Positive' => 'white',
            '2_Black & White Positive'   => 'white',
            '2_Primary Color Negative'   => 'white',
            '2_Secondary Color Negative' => 'white',
            '2_Black & White Negative'   => 'white',
            '2_Primary & Colors'         => 'white',
            '2_Secondary & Colors'       => 'white',
            'alt1'                       => 'white',
            'alt2'                       => 'white'
        ];

    const LOGO_NAME_COLOR
        = [
            '0_Primary & Black'          => 'black',
            '0_Secondary & Black'        => 'black',
            '0_White & Black'            => 'black',
            '1_Primary & Black'          => 'black',
            '1_Secondary & Black'        => 'black',
            '1_White & Black'            => 'black',
            '2_Primary & Black'          => 'black',
            '2_Secondary & Black'        => 'black',
            '2_White & Black'            => 'black',
            '0_Primary Color Positive'   => 'primary',
            '0_Secondary Color Positive' => 'primary',
            '0_Black & White Positive'   => 'primary',
            '0_Primary Color Negative'   => 'primary',
            '0_Secondary Color Negative' => 'primary',
            '0_Black & White Negative'   => 'primary',
            '0_Primary & Colors'         => 'primary',
            '0_Secondary & Colors'       => 'primary',
            '0_Positive on Black'        => 'primary',
            '1_Primary Color Positive'   => 'primary',
            '1_Secondary Color Positive' => 'primary',
            '1_Black & White Positive'   => 'primary',
            '1_Primary Color Negative'   => 'primary',
            '1_Secondary Color Negative' => 'primary',
            '1_Black & White Negative'   => 'primary',
            '1_Primary & Colors'         => 'primary',
            '1_Secondary & Colors'       => 'primary',
            '1_Positive on Black'        => 'primary',
            '2_Primary Color Positive'   => 'primary',
            '2_Secondary Color Positive' => 'primary',
            '2_Black & White Positive'   => 'primary',
            '2_Primary Color Negative'   => 'primary',
            '2_Secondary Color Negative' => 'primary',
            '2_Black & White Negative'   => 'primary',
            '2_Primary & Colors'         => 'primary',
            '2_Secondary & Colors'       => 'primary',
            '2_Positive on Black'        => 'primary',
            'alt1'                       => 'primary',
            'alt2'                       => 'primary'
        ];

    const LOGO_VARIATIONS_BG_COLOR_LIST
        = [
            'main'      => 'main-color-background',
            'black'     => 'black-background',
            'secondary' => 'secondary-color-background'
        ];


    const STR_LENGTH_TO_FONT
        = [
            'template4' => [
                'vision'  => [
                    [ 'length' => 350, 'font' => 24 ],
                    [ 'length' => 600, 'font' => 22 ],
                    [ 'length' => 700, 'font' => 20 ],
                    'default' => 28,
                ],
                'mission' => [
                    [ 'length' => 350, 'font' => 24 ],
                    [ 'length' => 600, 'font' => 22 ],
                    [ 'length' => 700, 'font' => 20 ],
                    'default' => 28
                ]
            ],
            'template5' => [
                'vision'  => [
                    [ 'length' => 150, 'font' => 24 ],
                    [ 'length' => 500, 'font' => 18 ],
                    [ 'length' => 700, 'font' => 16 ],
                    'default' => 38
                ],
                'mission' => [
                    [ 'length' => 150, 'font' => 21 ],
                    [ 'length' => 500, 'font' => 18 ],
                    [ 'length' => 700, 'font' => 16 ],
                    'default' => 38
                ]
            ],
        ];

    const ARCHETYPES = [
        'The Magician'  => [
            'description'         => 'It is a smart and intelligent archetype, aiming to make all the wishes come true. The Magician brands oftentimes convert their groundbreaking knowledge into innovative technology. Audiences of this type need to be provided with a solution to their problem, or to be in on the secret information.',
            'short_description'   => 'Think of Nikola Tesla, Disney or Apple.',
            'short_description_1' => 'Think of Nikola Tesla',
            'short_description_2' => 'Disney or Apple.',
        ],
        'The Creator'   => [
            'description'         => 'The Creator are nonconformists, driven by a desire for the self-expression. They have their own vision, and try to create something truly unique. With their project, they aim at uncovering the true potential and creativity of their audience.',
            'short_description'   => 'Think of Pharrell Williams, Adobe or Lego.',
            'short_description_1' => 'Think of Pharrell Williams',
            'short_description_2' => 'Adobe or Lego.',
        ],
        'The Ruler'     => [
            'description'         => 'The Ruler controls everything. They are too responsible, and have too many tasks on their plate. Goods catered to this archetype help balance the pressure, take off some of the tasks, while confirming the status and power of the client.',
            'short_description'   => 'Think of Angela Merkel, Microsoft or Mercedes-Benz',
            'short_description_1' => 'Think of Angela Merkel',
            'short_description_2' => 'Microsoft or Mercedes-Benz',
        ],
        'The Lover'     => [
            'description'         => 'The Lover brands help their clients to feel special and loved. If the brand puts the pleasure of a client as top priority, the customer will remain forever in love with the company.',
            'short_description'   => 'Think of Antonio Banderas, Victoria\'s Secret, or Chanel.',
            'short_description_1' => 'Think of Antonio Banderas',
            'short_description_2' => 'Victoria\'s Secret, or Chanel.',
        ],
        'The Caregiver' => [
            'description'         => 'The Caregiver is an altruist, driven by the generosity and desire to help others. The brands of this archetype do not just serve, they analyze and take note of their client\'s needs and wishes.',
            'short_description'   => 'Think of Princess Diana, Johnson’s Baby or Campbell’s Soup.',
            'short_description_1' => 'Think of Princess Diana',
            'short_description_2' => 'Johnson’s Baby, or Campbell’s Soup.',
        ],
        'The Jester'    => [
            'description'         => 'Jesters are the brands that laugh in every situation – they are playful and love to break the rules. They entertain their audince, make fun of seriousness, and offer positive experiences to live through.',
            'short_description'   => 'Think of Jim Carrey, Fanta or M&M.',
            'short_description_1' => 'Think of Jim Carrey',
            'short_description_2' => 'Fanta, or M&M.',
        ],
        'The Rebel'     => [
            'description'         => 'The Rebels believe that there is only one way to change the usual pace of things: through revolutions. Their meaning of life is to destroy something old to give way for something new.',
            'short_description'   => 'Think of Vivienne Westwood, Harley Davidson or Diesel.',
            'short_description_1' => 'Think of Vivienne Westwood',
            'short_description_2' => 'Harley Davidson, or Diesel.',
        ],
        'The Sage'      => [
            'description'         => 'The Sage want to get at the truth by learning how the world is built. They analyze, structurize and then share everything they have found with their audience. They want people to understand the world better.',
            'short_description'   => 'Think of Oprah Winfrey, NASA or The Discovery Channel.',
            'short_description_1' => 'Think of Oprah Winfrey',
            'short_description_2' => 'NASA, or The Discovery Channel.',
        ],
        'The Explorer'  => [
            'description'         => 'The feeling of the life pulse, new experiences, travel are of the top priority for the Explorer. The fact of the journey means nothing to them, they love the process itself. The brands of this archetype aspire to ditch the norms and indulge in a new adventure.',
            'short_description'   => 'Think of Elon Musk, Red Bull or The North Face.',
            'short_description_1' => 'Think of Elon Musk',
            'short_description_2' => 'Red Bull, or The North Face.',
        ],
        'The Hero'      => [
            'description'         => 'The Hero leads the way. They are impressive in their courage, and always do as they deem right. The Hero is always up for a challenge, and likes to challenge others as well. They fight villains, and aspire to make the world a better place.',
            'short_description'   => 'Think of Martin Luther King, Nike or Duracell.',
            'short_description_1' => 'Think of Martin Luther King',
            'short_description_2' => 'Nike, or Duracell.',
        ],
        'The Everyman'  => [
            'description'         => 'The Everyman hates elitism and poshness. They are simple, wholesome and thinks that everyone in the world is born different. With their cheerful mood, and openness they are a friend, a companion, the guy next door.',
            'short_description'   => 'Think of Jennifer Aniston, Facebook or GAP.',
            'short_description_1' => 'Think of Jennifer Aniston',
            'short_description_2' => 'Facebook, or GAP.',
        ],
        'The Innocent'  => [
            'description'         => 'The Innocent lives in the utopian world, where they need to be a part of it. They try their best to only do right things, so that they don\'t stand out. Can be easy to start following trends, if there is a chance to improve the world in any way.',
            'short_description'   => 'Think of Michel Gondry, Coca Cola or Dove soap.',
            'short_description_1' => 'Think of Michel Gondry',
            'short_description_2' => 'Coca Cola, or Dove soap.',
        ],
    ];

    public static function getSVG_src( $archetype ) {
        $file_name = str_replace( ' ', '', strtolower( $archetype ) );
        if ( $file_name ) {
            $file_name .= '.svg';
            return \File::get( public_path( 'img' ) . DIRECTORY_SEPARATOR . 'archetypes' . DIRECTORY_SEPARATOR . $file_name );
        }
        return false;
    }

    public static function isCompleted( Brandbook $brandbook ) {

        $pdf_links = json_decode( $brandbook->pdf_link, true );

        $theme_id = is_numeric( $brandbook->theme ) ? $brandbook->theme : null;
        if ( !$theme_id ) {
            return false;
        }

        if ( empty( $pdf_links ) ) {
            return false;
        }

        if ( $brandbook->finished() ) {
            return true;
        }

        return false;
    }

    public static function getFontSize( $str, $type, $template ) {

        $length = strlen( $str );
        $values = self::STR_LENGTH_TO_FONT[ $template ][ $type ];

        if ( $length < $values[ 0 ][ 'length' ] ) {
            return $values[ 'default' ];
        }

        if ( $length >= $values[ 0 ][ 'length' ] && $length <= $values[ 1 ][ 'length' ] ) {
            return $values[ 0 ][ 'font' ];
        }

        if ( $length > $values[ 1 ][ 'length' ] && $length <= $values[ 2 ][ 'length' ] ) {
            return $values[ 1 ][ 'font' ];
        }

        return $values[ 2 ][ 'font' ];
    }

    public static function themeLogoVariations( $approved, $type ) {

        $logos = [];
        foreach ( $approved as $item ) {
            if ( in_array( $item->id, self::PAGED_LOGOS[ $type ] ) ) {
                $logos[] = $item;
            }
        }

        if ( $type == self::LOGOS_PAGED_TYPE_BLACK ) {
            $chunk_size = round( count( $logos ) / 2 );
            return collect( $logos )->chunk( $chunk_size );
        }


        return $type == self::LOGOS_PAGED_TYPE_OTHER ? collect( $logos )->chunk( 12 ) : collect( $logos );
    }

    public static function nameColors( $color_list_length ) {

        $names = [];
        for ( $i = 0; $i < $color_list_length; $i++ ) {
            if ( !empty( self::COLOR_NAME_LIST[ $i ] ) ) {
                $names[ $i ] = trans( 'themes.' . self::COLOR_NAME_LIST[ $i ] );
            } else {
                $names[ $i ] = $i + 1 . trans( 'themes.color' );
            }
        }
        return $names;
    }

    public static function borderRadius( $icon_name ) {

        return strpos( strtolower( $icon_name ), 'circle' ) !== false;
    }

    public static function paginateColors( $color_list ) {

        $colors = [];
        if ( count( $color_list ) > 4 ) {
            $colors[] = $color_list[ 0 ]->id;
            $colors[] = !empty( $color_list[ 5 ] ) ? $color_list[ 5 ]->id : '#DDDDDD';
        } else {
            $colors[] = $color_list[ 0 ]->id;
            $colors[] = !empty( $color_list[ 3 ] ) ? $color_list[ 3 ]->id : '#DDDDDD';
        }
        return $colors;
    }

    public static function pageNumber( &$pageNumber ) {

        $pageNumber++;
        if ( $pageNumber < 10 ) {
            $pageNumber = 0 . $pageNumber;
        }
    }

    public static function fromCamelCase( $input ) {

        preg_match_all( '!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches );
        $ret = $matches[ 0 ];
        foreach ( $ret as &$match ) {
            $match = $match == strtoupper( $match ) ? strtolower( $match ) : lcfirst( $match );
        }
        return implode( '-', $ret );
    }

    public static function adjustBrightness( $hex, $steps ) {

        // Steps should be between -255 and 255. Negative = darker, positive = lighter
        $steps = max( -255, min( 255, $steps ) );

        // Normalize into a six character long hex string
        $hex = str_replace( '#', '', $hex );
        if ( strlen( $hex ) == 3 ) {
            $hex = str_repeat( substr( $hex, 0, 1 ), 2 ) . str_repeat( substr( $hex, 1, 1 ), 2 ) . str_repeat( substr( $hex, 2, 1 ), 2 );
        }

        // Split into three parts: R, G and B
        $color_parts = str_split( $hex, 2 );
        $return      = '#';

        foreach ( $color_parts as $color ) {
            $color  = hexdec( $color ); // Convert to decimal
            $color  = max( 0, min( 255, $color + $steps ) ); // Adjust color
            $return .= str_pad( dechex( $color ), 2, '0', STR_PAD_LEFT ); // Make two char hex code
        }

        return $return;
    }

    public static function getLogoTextColor( $background ) {
        if ( $background === 'black' ) {
            return '#ffffff';
        }

        if ( $background === 'other' ) {
            return '#000000';
        }
        try {
            return self::getContrastColor( $background );
        } catch ( \Exception $e ) {
            info( $background );
            info( $e->getMessage() );
            info( $e->getTraceAsString() );
            return '#ffffff';
        }
    }

    public static function getContrastColor( $bg, $class = false ) {

        $color = new \Mexitek\PHPColors\Color( $bg );

        if ( $color->isDark() ) {
            return $class ? 'light' : '#ffffff';
        }

        return $class ? 'dark' : '#000000';
    }

    public static function getIconWrapperSize( $icon_count ) {

        if ( $icon_count <= 2 ) {
            return 'size-3';
        }
        if ( $icon_count <= 8 ) {
            return 'size-2';
        }
        return 'size-1';
    }

    public static function getIconBreakCount( $icon_count ) {

        if ( $icon_count <= 2 ) {
            return 2;
        }
        if ( $icon_count <= 8 ) {
            return 5;
        }
        return 7;
    }

    public static function lastPageFullLogo( $i, $j, $logo_h, $logo_w, &$showed ) {

        if ( $showed ) {
            return false;
        }

        if ( ( $j >= ( $logo_w * 2 ) && ( $i + $logo_h * 2 ) >= 600 ) ) {
            $showed = true;
            return true;
        }
        return false;
    }

    public static function chunkLogoVariations( $approved, $logo_versions = [] ) {

        if ( !empty( $logo_versions ) && count( $logo_versions ) > 1 ) {
            if ( !empty( $logo_versions[ 1 ] ) ) {
                $alt1             = $logo_versions[ 1 ];
                $alt1->background = 'transparent';
                array_unshift( $approved, $alt1 );
            }

            if ( !empty( $logo_versions[ 2 ] ) ) {
                $alt2             = $logo_versions[ 2 ];
                $alt2->background = 'transparent';
                array_unshift( $approved, $alt2 );
            }
        }

        switch ( count( $approved ) ) {
            case 1 :
                return [
                    [
                        [
                            'logo'       => $approved[ 0 ]->logo_b64,
                            'background' => $approved[ 0 ]->background,
                            'title'      => $approved[ 0 ]->title
                        ]
                    ]
                ];
            case  2 :
                return [
                    [
                        [
                            'logo'       => $approved[ 0 ]->logo_b64,
                            'background' => $approved[ 0 ]->background,
                            'title'      => $approved[ 0 ]->title
                        ],
                        [
                            'logo'       => $approved[ 1 ]->logo_b64,
                            'background' => $approved[ 1 ]->background,
                            'title'      => $approved[ 1 ]->title
                        ]
                    ]
                ];
            case 3:
                return [
                    [
                        [
                            'logo'       => $approved[ 0 ]->logo_b64,
                            'background' => $approved[ 0 ]->background,
                            'title'      => $approved[ 0 ]->title
                        ]

                    ], [
                        [
                            'logo'       => $approved[ 1 ]->logo_b64,
                            'background' => $approved[ 1 ]->background,
                            'title'      => $approved[ 1 ]->title
                        ]
                    ], [
                        [
                            'logo'       => $approved[ 2 ]->logo_b64,
                            'background' => $approved[ 2 ]->background,
                            'title'      => $approved[ 2 ]->title
                        ]
                    ]
                ];
            case 4:
                return [
                    [
                        [
                            'logo'       => $approved[ 0 ]->logo_b64,
                            'background' => $approved[ 0 ]->background,
                            'title'      => $approved[ 0 ]->title
                        ],

                        [
                            'logo'       => $approved[ 1 ]->logo_b64,
                            'background' => $approved[ 1 ]->background,
                            'title'      => $approved[ 1 ]->title
                        ],
                        [
                            'logo'       => $approved[ 2 ]->logo_b64,
                            'background' => $approved[ 2 ]->background,
                            'title'      => $approved[ 2 ]->title
                        ],
                        [
                            'logo'       => $approved[ 3 ]->logo_b64,
                            'background' => $approved[ 3 ]->background,
                            'title'      => $approved[ 3 ]->title
                        ]
                    ]
                ];
            case 5:
                return [
                    [
                        [
                            'logo'       => $approved[ 0 ]->logo_b64,
                            'background' => $approved[ 0 ]->background,
                            'title'      => $approved[ 0 ]->title
                        ]
                    ],
                    [
                        [
                            'logo'       => $approved[ 1 ]->logo_b64,
                            'background' => $approved[ 1 ]->background,
                            'title'      => $approved[ 1 ]->title
                        ],
                        [
                            'logo'       => $approved[ 2 ]->logo_b64,
                            'background' => $approved[ 2 ]->background,
                            'title'      => $approved[ 2 ]->title
                        ],
                    ],
                    [
                        [
                            'logo'       => $approved[ 3 ]->logo_b64,
                            'background' => $approved[ 3 ]->background,
                            'title'      => $approved[ 3 ]->title
                        ],
                        [
                            'logo'       => $approved[ 4 ]->logo_b64,
                            'background' => $approved[ 4 ]->background,
                            'title'      => $approved[ 4 ]->title
                        ]
                    ]
                ];
            case 6:
                return [
                    [
                        [
                            'logo'       => $approved[ 0 ]->logo_b64,
                            'background' => $approved[ 0 ]->background,
                            'title'      => $approved[ 0 ]->title
                        ],
                        [
                            'logo'       => $approved[ 1 ]->logo_b64,
                            'background' => $approved[ 1 ]->background,
                            'title'      => $approved[ 1 ]->title
                        ],
                    ],
                    [
                        [
                            'logo'       => $approved[ 2 ]->logo_b64,
                            'background' => $approved[ 2 ]->background,
                            'title'      => $approved[ 2 ]->title
                        ],
                        [
                            'logo'       => $approved[ 3 ]->logo_b64,
                            'background' => $approved[ 3 ]->background,
                            'title'      => $approved[ 3 ]->title
                        ],
                    ],
                    [
                        [
                            'logo'       => $approved[ 4 ]->logo_b64,
                            'background' => $approved[ 4 ]->background,
                            'title'      => $approved[ 4 ]->title
                        ],
                        [
                            'logo'       => $approved[ 5 ]->logo_b64,
                            'background' => $approved[ 5 ]->background,
                            'title'      => $approved[ 5 ]->title
                        ]
                    ]
                ];
            case 7 :
                return [
                    [
                        [
                            'logo'       => $approved[ 0 ]->logo_b64,
                            'background' => $approved[ 0 ]->background,
                            'title'      => $approved[ 0 ]->title
                        ],

                        [
                            'logo'       => $approved[ 1 ]->logo_b64,
                            'background' => $approved[ 1 ]->background,
                            'title'      => $approved[ 1 ]->title
                        ],
                        [
                            'logo'       => $approved[ 2 ]->logo_b64,
                            'background' => $approved[ 2 ]->background,
                            'title'      => $approved[ 2 ]->title
                        ],
                        [
                            'logo'       => $approved[ 3 ]->logo_b64,
                            'background' => $approved[ 3 ]->background,
                            'title'      => $approved[ 3 ]->title
                        ]
                    ],
                    [
                        [
                            'logo'       => $approved[ 4 ]->logo_b64,
                            'background' => $approved[ 4 ]->background,
                            'title'      => $approved[ 4 ]->title
                        ],
                        [
                            'logo'       => $approved[ 5 ]->logo_b64,
                            'background' => $approved[ 5 ]->background,
                            'title'      => $approved[ 5 ]->title
                        ]
                    ],
                    [
                        [
                            'logo'       => $approved[ 6 ]->logo_b64,
                            'background' => $approved[ 6 ]->background,
                            'title'      => $approved[ 6 ]->title
                        ]
                    ]
                ];
            case 8:
                return [
                    [
                        [
                            'logo'       => $approved[ 0 ]->logo_b64,
                            'background' => $approved[ 0 ]->background,
                            'title'      => $approved[ 0 ]->title
                        ],

                        [
                            'logo'       => $approved[ 1 ]->logo_b64,
                            'background' => $approved[ 1 ]->background,
                            'title'      => $approved[ 1 ]->title
                        ],
                        [
                            'logo'       => $approved[ 2 ]->logo_b64,
                            'background' => $approved[ 2 ]->background,
                            'title'      => $approved[ 2 ]->title
                        ],
                        [
                            'logo'       => $approved[ 3 ]->logo_b64,
                            'background' => $approved[ 3 ]->background,
                            'title'      => $approved[ 3 ]->title
                        ]
                    ],
                    [
                        [
                            'logo'       => $approved[ 4 ]->logo_b64,
                            'background' => $approved[ 4 ]->background,
                            'title'      => $approved[ 4 ]->title
                        ],
                        [
                            'logo'       => $approved[ 5 ]->logo_b64,
                            'background' => $approved[ 5 ]->background,
                            'title'      => $approved[ 5 ]->title
                        ]
                    ],
                    [
                        [
                            'logo'       => $approved[ 6 ]->logo_b64,
                            'background' => $approved[ 6 ]->background,
                            'title'      => $approved[ 6 ]->title
                        ],
                        [
                            'logo'       => $approved[ 7 ]->logo_b64,
                            'background' => $approved[ 7 ]->background,
                            'title'      => $approved[ 7 ]->title
                        ]
                    ]
                ];
            case 9:
                return [
                    [
                        [
                            'logo'       => $approved[ 0 ]->logo_b64,
                            'background' => $approved[ 0 ]->background,
                            'title'      => $approved[ 0 ]->title
                        ]
                    ],
                    [
                        [
                            'logo'       => $approved[ 1 ]->logo_b64,
                            'background' => $approved[ 1 ]->background,
                            'title'      => $approved[ 1 ]->title
                        ],
                        [
                            'logo'       => $approved[ 2 ]->logo_b64,
                            'background' => $approved[ 2 ]->background,
                            'title'      => $approved[ 2 ]->title
                        ],
                        [
                            'logo'       => $approved[ 3 ]->logo_b64,
                            'background' => $approved[ 3 ]->background,
                            'title'      => $approved[ 3 ]->title
                        ],
                        [
                            'logo'       => $approved[ 4 ]->logo_b64,
                            'background' => $approved[ 4 ]->background,
                            'title'      => $approved[ 4 ]->title
                        ],
                    ],
                    [
                        [
                            'logo'       => $approved[ 5 ]->logo_b64,
                            'background' => $approved[ 5 ]->background,
                            'title'      => $approved[ 5 ]->title
                        ],
                        [
                            'logo'       => $approved[ 6 ]->logo_b64,
                            'background' => $approved[ 6 ]->background,
                            'title'      => $approved[ 6 ]->title
                        ],
                        [
                            'logo'       => $approved[ 7 ]->logo_b64,
                            'background' => $approved[ 7 ]->background,
                            'title'      => $approved[ 7 ]->title
                        ],
                        [
                            'logo'       => $approved[ 8 ]->logo_b64,
                            'background' => $approved[ 8 ]->background,
                            'title'      => $approved[ 8 ]->title
                        ],
                    ]
                ];
            case 10:
                return [
                    [
                        [
                            'logo'       => $approved[ 0 ]->logo_b64,
                            'background' => $approved[ 0 ]->background,
                            'title'      => $approved[ 0 ]->title
                        ],
                        [
                            'logo'       => $approved[ 1 ]->logo_b64,
                            'background' => $approved[ 1 ]->background,
                            'title'      => $approved[ 1 ]->title
                        ],
                    ],
                    [
                        [
                            'logo'       => $approved[ 2 ]->logo_b64,
                            'background' => $approved[ 2 ]->background,
                            'title'      => $approved[ 2 ]->title
                        ],
                        [
                            'logo'       => $approved[ 3 ]->logo_b64,
                            'background' => $approved[ 3 ]->background,
                            'title'      => $approved[ 3 ]->title
                        ],
                        [
                            'logo'       => $approved[ 4 ]->logo_b64,
                            'background' => $approved[ 4 ]->background,
                            'title'      => $approved[ 4 ]->title
                        ],
                        [
                            'logo'       => $approved[ 5 ]->logo_b64,
                            'background' => $approved[ 5 ]->background,
                            'title'      => $approved[ 5 ]->title
                        ],
                    ],
                    [
                        [
                            'logo'       => $approved[ 6 ]->logo_b64,
                            'background' => $approved[ 6 ]->background,
                            'title'      => $approved[ 6 ]->title
                        ],
                        [
                            'logo'       => $approved[ 7 ]->logo_b64,
                            'background' => $approved[ 7 ]->background,
                            'title'      => $approved[ 7 ]->title
                        ],
                        [
                            'logo'       => $approved[ 8 ]->logo_b64,
                            'background' => $approved[ 8 ]->background,
                            'title'      => $approved[ 8 ]->title
                        ],
                        [
                            'logo'       => $approved[ 9 ]->logo_b64,
                            'background' => $approved[ 9 ]->background,
                            'title'      => $approved[ 9 ]->title
                        ],
                    ]
                ];
            case 11:
                return [
                    [
                        [
                            'logo'       => $approved[ 1 ]->logo_b64,
                            'background' => $approved[ 1 ]->background,
                            'title'      => $approved[ 1 ]->title
                        ],
                        [
                            'logo'       => $approved[ 2 ]->logo_b64,
                            'background' => $approved[ 2 ]->background,
                            'title'      => $approved[ 2 ]->title
                        ],
                    ],
                    [

                        [
                            'logo'       => $approved[ 3 ]->logo_b64,
                            'background' => $approved[ 3 ]->background,
                            'title'      => $approved[ 3 ]->title
                        ],
                        [
                            'logo'       => $approved[ 4 ]->logo_b64,
                            'background' => $approved[ 4 ]->background,
                            'title'      => $approved[ 4 ]->title
                        ],
                        [
                            'logo'       => $approved[ 5 ]->logo_b64,
                            'background' => $approved[ 5 ]->background,
                            'title'      => $approved[ 5 ]->title
                        ],
                        [
                            'logo'       => $approved[ 6 ]->logo_b64,
                            'background' => $approved[ 6 ]->background,
                            'title'      => $approved[ 6 ]->title
                        ]
                    ],
                    [
                        [
                            'logo'       => $approved[ 7 ]->logo_b64,
                            'background' => $approved[ 7 ]->background,
                            'title'      => $approved[ 7 ]->title
                        ],
                        [
                            'logo'       => $approved[ 8 ]->logo_b64,
                            'background' => $approved[ 8 ]->background,
                            'title'      => $approved[ 8 ]->title
                        ],
                        [
                            'logo'       => $approved[ 9 ]->logo_b64,
                            'background' => $approved[ 9 ]->background,
                            'title'      => $approved[ 9 ]->title
                        ],
                        [
                            'logo'       => $approved[ 10 ]->logo_b64,
                            'background' => $approved[ 10 ]->background,
                            'title'      => $approved[ 10 ]->title
                        ],
                    ]
                ];
            case 12:
                return [
                    [
                        [
                            'logo'       => $approved[ 0 ]->logo_b64,
                            'background' => $approved[ 0 ]->background,
                            'title'      => $approved[ 0 ]->title
                        ],
                        [
                            'logo'       => $approved[ 1 ]->logo_b64,
                            'background' => $approved[ 1 ]->background,
                            'title'      => $approved[ 1 ]->title
                        ],
                        [
                            'logo'       => $approved[ 2 ]->logo_b64,
                            'background' => $approved[ 2 ]->background,
                            'title'      => $approved[ 2 ]->title
                        ],
                        [
                            'logo'       => $approved[ 3 ]->logo_b64,
                            'background' => $approved[ 3 ]->background,
                            'title'      => $approved[ 3 ]->title
                        ],
                    ],
                    [

                        [
                            'logo'       => $approved[ 4 ]->logo_b64,
                            'background' => $approved[ 4 ]->background,
                            'title'      => $approved[ 4 ]->title
                        ],
                        [
                            'logo'       => $approved[ 5 ]->logo_b64,
                            'background' => $approved[ 5 ]->background,
                            'title'      => $approved[ 5 ]->title
                        ],
                        [
                            'logo'       => $approved[ 6 ]->logo_b64,
                            'background' => $approved[ 6 ]->background,
                            'title'      => $approved[ 6 ]->title
                        ],
                        [
                            'logo'       => $approved[ 7 ]->logo_b64,
                            'background' => $approved[ 7 ]->background,
                            'title'      => $approved[ 7 ]->title
                        ]
                    ],
                    [
                        [
                            'logo'       => $approved[ 8 ]->logo_b64,
                            'background' => $approved[ 8 ]->background,
                            'title'      => $approved[ 8 ]->title
                        ],
                        [
                            'logo'       => $approved[ 9 ]->logo_b64,
                            'background' => $approved[ 9 ]->background,
                            'title'      => $approved[ 9 ]->title
                        ],
                        [
                            'logo'       => $approved[ 10 ]->logo_b64,
                            'background' => $approved[ 10 ]->background,
                            'title'      => $approved[ 10 ]->title
                        ],
                        [
                            'logo'       => $approved[ 11 ]->logo_b64,
                            'background' => $approved[ 11 ]->background,
                            'title'      => $approved[ 11 ]->title
                        ],
                    ]
                ];
            case 13:
                return [
                    [
                        [
                            'logo'       => $approved[ 0 ]->logo_b64,
                            'background' => $approved[ 0 ]->background,
                            'title'      => $approved[ 0 ]->title
                        ],
                    ],
                    [
                        [
                            'logo'       => $approved[ 1 ]->logo_b64,
                            'background' => $approved[ 1 ]->background,
                            'title'      => $approved[ 1 ]->title
                        ],
                        [
                            'logo'       => $approved[ 2 ]->logo_b64,
                            'background' => $approved[ 2 ]->background,
                            'title'      => $approved[ 2 ]->title
                        ]

                    ],
                    [
                        [
                            'logo'       => $approved[ 3 ]->logo_b64,
                            'background' => $approved[ 3 ]->background,
                            'title'      => $approved[ 3 ]->title
                        ],
                        [
                            'logo'       => $approved[ 4 ]->logo_b64,
                            'background' => $approved[ 4 ]->background,
                            'title'      => $approved[ 4 ]->title
                        ],
                    ],
                    [

                        [
                            'logo'       => $approved[ 5 ]->logo_b64,
                            'background' => $approved[ 5 ]->background,
                            'title'      => $approved[ 5 ]->title
                        ],
                        [
                            'logo'       => $approved[ 6 ]->logo_b64,
                            'background' => $approved[ 6 ]->background,
                            'title'      => $approved[ 6 ]->title
                        ],
                        [
                            'logo'       => $approved[ 7 ]->logo_b64,
                            'background' => $approved[ 7 ]->background,
                            'title'      => $approved[ 7 ]->title
                        ],
                        [
                            'logo'       => $approved[ 8 ]->logo_b64,
                            'background' => $approved[ 8 ]->background,
                            'title'      => $approved[ 8 ]->title
                        ]
                    ],
                    [
                        [
                            'logo'       => $approved[ 9 ]->logo_b64,
                            'background' => $approved[ 9 ]->background,
                            'title'      => $approved[ 9 ]->title
                        ],
                        [
                            'logo'       => $approved[ 10 ]->logo_b64,
                            'background' => $approved[ 10 ]->background,
                            'title'      => $approved[ 10 ]->title
                        ],
                        [
                            'logo'       => $approved[ 11 ]->logo_b64,
                            'background' => $approved[ 11 ]->background,
                            'title'      => $approved[ 11 ]->title
                        ],
                        [
                            'logo'       => $approved[ 12 ]->logo_b64,
                            'background' => $approved[ 12 ]->background,
                            'title'      => $approved[ 12 ]->title
                        ],
                    ]
                ];
            case 14:
                return [
                    [
                        [
                            'logo'       => $approved[ 0 ]->logo_b64,
                            'background' => $approved[ 0 ]->background,
                            'title'      => $approved[ 0 ]->title
                        ],
                        [
                            'logo'       => $approved[ 1 ]->logo_b64,
                            'background' => $approved[ 1 ]->background,
                            'title'      => $approved[ 1 ]->title
                        ],
                    ],
                    [
                        [
                            'logo'       => $approved[ 2 ]->logo_b64,
                            'background' => $approved[ 2 ]->background,
                            'title'      => $approved[ 2 ]->title
                        ],
                        [
                            'logo'       => $approved[ 3 ]->logo_b64,
                            'background' => $approved[ 3 ]->background,
                            'title'      => $approved[ 3 ]->title
                        ]

                    ],
                    [
                        [
                            'logo'       => $approved[ 4 ]->logo_b64,
                            'background' => $approved[ 4 ]->background,
                            'title'      => $approved[ 4 ]->title
                        ],
                        [
                            'logo'       => $approved[ 5 ]->logo_b64,
                            'background' => $approved[ 5 ]->background,
                            'title'      => $approved[ 5 ]->title
                        ],
                    ],
                    [

                        [
                            'logo'       => $approved[ 6 ]->logo_b64,
                            'background' => $approved[ 6 ]->background,
                            'title'      => $approved[ 6 ]->title
                        ],
                        [
                            'logo'       => $approved[ 7 ]->logo_b64,
                            'background' => $approved[ 7 ]->background,
                            'title'      => $approved[ 7 ]->title
                        ],
                        [
                            'logo'       => $approved[ 8 ]->logo_b64,
                            'background' => $approved[ 8 ]->background,
                            'title'      => $approved[ 8 ]->title
                        ],
                        [
                            'logo'       => $approved[ 9 ]->logo_b64,
                            'background' => $approved[ 9 ]->background,
                            'title'      => $approved[ 9 ]->title
                        ]
                    ],
                    [
                        [
                            'logo'       => $approved[ 10 ]->logo_b64,
                            'background' => $approved[ 10 ]->background,
                            'title'      => $approved[ 10 ]->title
                        ],
                        [
                            'logo'       => $approved[ 11 ]->logo_b64,
                            'background' => $approved[ 11 ]->background,
                            'title'      => $approved[ 11 ]->title
                        ],
                        [
                            'logo'       => $approved[ 12 ]->logo_b64,
                            'background' => $approved[ 12 ]->background,
                            'title'      => $approved[ 12 ]->title
                        ],
                        [
                            'logo'       => $approved[ 13 ]->logo_b64,
                            'background' => $approved[ 13 ]->background,
                            'title'      => $approved[ 13 ]->title
                        ],
                    ]
                ];
        }
    }

    public static function getLogoBackground( $logo_id ) {
        foreach ( self::PAGED_LOGOS as $background_color => $logo_ids ) {
            foreach ( $logo_ids as $LOGO_ID ) {
                if ( $LOGO_ID === $logo_id ) {
                    return $background_color;
                }
            }
        }
        return 'other';
    }

    public static function orderLogoVariations( $approved, $logo_versions ) {

        $ordered = [];

        foreach ( self::LOGO_VARIATIONS_ORDER as $item ) {

            if ( 'alt1' == $item && !empty( $logo_versions[ 1 ] ) ) {
                $logo_versions[ 1 ]->background = 'transparent';
                $logo_versions[ 1 ]->id         = 'alt1';
                $ordered[]                      = $logo_versions[ 1 ];
                continue;
            }

            if ( 'alt2' == $item && !empty( $logo_versions[ 2 ] ) ) {
                $logo_versions[ 2 ]->background = 'transparent';
                $logo_versions[ 2 ]->id         = 'alt2';
                $ordered[]                      = $logo_versions[ 2 ];
                continue;
            }

            foreach ( $approved as $approved_item ) {
                if ( $item == $approved_item->id ) {
                    $ordered[] = $approved_item;
                }
            }
        }

        return collect( $ordered )->chunk( 4 );
    }

    public static function getLogoVariationsPageBgColor( $page_num ) {

        if ( $page_num == 0 ) {
            return self::LOGO_VARIATIONS_BG_COLOR_LIST[ 'main' ];
        }

        if ( $page_num == 1 || $page_num == 2 ) {
            return self::LOGO_VARIATIONS_BG_COLOR_LIST[ 'black' ];
        }

        return self::LOGO_VARIATIONS_BG_COLOR_LIST[ 'secondary' ];
    }

    public static function freeSpaceIcon( $icon_w, $icon_h, &$data ) {

        $shorter      = 0;
        $longer       = 0;
        $shorter_text = 'x';
        $longer_text  = 'y';

        if ( $icon_w > $icon_h ) {
            $data->icon_w = 60;
            $data->icon_h = $icon_h * 60 / $icon_w;
        } else {
            $data->icon_h = 60;
            $data->icon_w = $icon_w * 60 / $icon_h;
        }

        if ( $data->icon_w < $data->icon_h ) {
            $shorter      = $data->icon_w;
            $longer       = $data->icon_h;
            $shorter_text = 'x';
            $longer_text  = 'y';
        } elseif ( ceil( $data->icon_w ) == ceil( $data->icon_h ) ) {
            $shorter = $data->icon_h;
            $longer  = $data->icon_h;
            if ( $shorter > 100 ) {
                $shorter      = 70;
                $longer       = 70;
                $data->icon_h = 70;
                $data->icon_w = 70;
            }
            $shorter_text = 'x';
            $longer_text  = 'x';
        } else {
            $shorter      = $data->icon_h;
            $longer       = $data->icon_w;
            $shorter_text = 'y';
            $longer_text  = 'x';
        }

        $new_r = $longer / $shorter;
        if ( $shorter != $longer ) {
            $free_sp_y_text = 'y';
            $free_sp_x_text = 'x';
        } else {
            $free_sp_y_text = 'x';
            $free_sp_x_text = 'x';
        }


        $free_sp_c_text   = '';
        $clear_space_text = '';
        $show_clear_icon  = false;
        switch ( $data->space ) {
            case 'newton':
                $show_clear_icon = false;
                if ( $new_r >= 1 && $new_r <= 1.6 ) {
                    $free_space_x   = '&frac13;' . $shorter_text;
                    $free_space_y   = '&frac13;' . $shorter_text;
                    $free_space_x_w = $shorter / 3;
                    $free_space_y_h = $shorter / 3;
                }
                if ( $new_r > 1.6 && $new_r <= 10 ) {
                    $free_space_x   = '&frac12;' . $shorter_text;
                    $free_space_y   = '&frac12;' . $shorter_text;
                    $free_space_x_w = $shorter / 2;
                    $free_space_y_h = $shorter / 2;
                }
                // if(r>=1.3){
                // 	this.free_space_x = '&frac13;x'
                // 	this.free_space_y = '&frac13;x'
                // 	this.free_space_x_w = this.logo_h/3
                // 	this.free_space_y_h = this.logo_h/3
                // }
                break;
            case 'hawkins':
                $show_clear_icon = false;
                if ( $new_r >= 1 && $new_r <= 1.6 ) {
                    $free_space_x   = '&frac12;' . $shorter_text;
                    $free_space_y   = '&frac12;' . $shorter_text;
                    $free_space_x_w = $shorter / 2;
                    $free_space_y_h = $shorter / 2;
                }
                if ( $new_r > 1.6 && $new_r <= 10 ) {
                    $free_space_x   = $shorter_text;
                    $free_space_y   = $shorter_text;
                    $free_space_x_w = $shorter;
                    $free_space_y_h = $shorter;
                }
                // this.free_space_x = Math.ceil(this.logo_w / r)
                // this.free_space_y = Math.ceil(this.logo_h / r)
                // this.free_space_x_w = this.logo_w/r
                // this.free_space_y_h = this.logo_h/r
                break;
            case 'einstein':
                $show_clear_icon = false;
                $free_sp_y_text  = 'y';
                $free_sp_x_text  = 'x';
                $free_sp_c_text  = '';
                if ( $new_r >= 1 && $new_r <= 1.39 ) {
                    $show_clear_icon = true;
                    if ( $shorter_text == 'x' ) {
                        $free_space_x   = '&frac23;' . $shorter_text;
                        $free_space_y   = '&frac23;' . $longer_text;
                        $free_space_x_w = $shorter * 2 / 3;
                        $free_space_y_h = $longer * 2 / 3;
                    } else {
                        $free_space_y   = '&frac23;' . $shorter_text;
                        $free_space_x   = '&frac23;' . $longer_text;
                        $free_space_y_h = $shorter * 2 / 3;
                        $free_space_x_w = $longer * 2 / 3;
                    }
                }
                if ( $new_r > 1.39 && $new_r <= 1.99 ) {
                    if ( $shorter_text == 'x' ) {
                        $free_space_x   = '&frac23;' . $shorter_text;
                        $free_space_y   = '&frac12;' . $longer_text;
                        $free_space_x_w = $shorter * 2 / 3;
                        $free_space_y_h = $longer / 2;
                    } else {
                        $free_space_y   = '&frac23;' . $shorter_text;
                        $free_space_x   = '&frac12;' . $longer_text;
                        $free_space_y_h = $shorter * 2 / 3;
                        $free_space_x_w = $longer / 2;
                    }
                }
                if ( $new_r > 1.99 && $new_r <= 2.99 ) {
                    if ( $shorter_text == 'x' ) {
                        $free_space_x   = '&frac23;' . $shorter_text;
                        $free_space_y   = '&frac13;' . $longer_text;
                        $free_space_x_w = $shorter * 2 / 3;
                        $free_space_y_h = $longer / 3;
                    } else {
                        $free_space_y   = '&frac23;' . $shorter_text;
                        $free_space_x   = '&frac13;' . $longer_text;
                        $free_space_y_h = $shorter * 2 / 3;
                        $free_space_x_w = $longer / 3;
                    }
                }
                if ( $new_r > 2.99 && $new_r <= 3.99 ) {
                    if ( $shorter_text == 'x' ) {
                        $free_space_x   = '&frac23;' . $shorter_text;
                        $free_space_y   = '&frac14;' . $longer_text;
                        $free_space_x_w = $shorter * 2 / 3;
                        $free_space_y_h = $longer / 4;
                    } else {
                        $free_space_y   = '&frac23;' . $shorter_text;
                        $free_space_x   = '&frac14;' . $longer_text;
                        $free_space_y_h = $shorter * 2 / 3;
                        $free_space_x_w = $longer / 4;
                    }
                }
                if ( $new_r > 3.99 && $new_r <= 4.99 ) {
                    if ( $shorter_text == 'x' ) {
                        $free_space_x   = '&frac23;' . $longer_text;
                        $free_space_y   = '&frac15;' . $shorter_text;
                        $free_space_x_w = $shorter * 2 / 3;
                        $free_space_y_h = $longer / 5;
                    } else {
                        $free_space_y   = '&frac23;' . $longer_text;
                        $free_space_x   = '&frac15;' . $shorter_text;
                        $free_space_y_h = $shorter * 2 / 3;
                        $free_space_x_w = $longer / 5;
                    }
                }
                if ( $new_r > 4.99 && $new_r <= 5.99 ) {
                    if ( $shorter_text == 'x' ) {
                        $free_space_x   = '&frac23;' + $shorter_text;
                        $free_space_y   = '&frac16;' + $longer_text;
                        $free_space_x_w = $shorter * 2 / 3;
                        $free_space_y_h = $longer / 6;
                    } else {
                        $free_space_y   = '&frac23;' . $shorter_text;
                        $free_space_x   = '&frac16;' . $longer_text;
                        $free_space_y_h = $shorter * 2 / 3;
                        $free_space_x_w = $longer / 6;
                    }
                }
                if ( $new_r > 5.99 && $new_r <= 6.99 ) {
                    if ( $shorter_text == 'x' ) {
                        $free_space_x   = '&frac23;' . $shorter_text;
                        $free_space_y   = '&frac17;' . $longer_text;
                        $free_space_x_w = $shorter * 2 / 3;
                        $free_space_y_h = $longer / 7;
                    } else {
                        $free_space_y   = '&frac23;' . $shorter_text;
                        $free_space_x   = '&frac17;' . $longer_text;
                        $free_space_y_h = $shorter * 2 / 3;
                        $free_space_x_w = $longer / 7;
                    }
                }
                if ( $new_r > 6.99 && $new_r <= 7.99 ) {
                    if ( $shorter_text == 'x' ) {
                        $free_space_x   = '&frac23;' . $shorter_text;
                        $free_space_y   = '&frac18;' . $longer_text;
                        $free_space_x_w = $shorter * 2 / 3;
                        $free_space_y_h = $longer / 8;
                    } else {
                        $free_space_y   = '&frac23;' . $shorter_text;
                        $free_space_x   = '&frac18;' . $longer_text;
                        $free_space_y_h = $shorter * 2 / 3;
                        $free_space_x_w = $longer / 8;
                    }
                }
                break;
            case 'pithagoras':
                $free_sp_y_text   = 'y';
                $free_sp_c_text   = 'c';
                $free_sp_x_text   = 'x';
                $show_clear_icon  = false;
                $clear_space_text = 'X&sup2; + Y&sup2; = C&sup2;';
                $diag             = sqrt( $shorter * $shorter + $longer * $longer );
                if ( $new_r >= 1 && $new_r <= 1.5 ) {
                    // var c = Math.sqrt(this.logo_/w*this.logo_w+this.logo_h*this.logo_h)/2
                    $free_space_x   = '&frac12;c';
                    $free_space_y   = '&frac12;c';
                    $free_space_x_w = $diag / 2;
                    $free_space_y_h = $diag / 2;
                }
                if ( $new_r > 1.5 && $new_r <= 3 ) {
                    // var c = Math.sqrt(this.logo_w*this.logo_w+this.logo_h*this.logo_h)/3
                    $free_space_x   = '&frac13;c';
                    $free_space_y   = '&frac13;c';
                    $free_space_x_w = $diag / 3;
                    $free_space_y_h = $diag / 3;
                }
                if ( $new_r > 3 && $new_r <= 4 ) {
                    // var c = Math.sqrt(this.logo_w*this.logo_w+this.logo_h*this.logo_h)/4
                    $free_space_x   = '&frac14;c';
                    $free_space_y   = '&frac14;c';
                    $free_space_x_w = $diag / 4;
                    $free_space_y_h = $diag / 4;
                }
                if ( $new_r > 4 && $new_r <= 5 ) {
                    // var c = Math.sqrt(this.logo_w*this.logo_w+this.logo_h*this.logo_h)/5
                    $free_space_x   = '&frac15;c';
                    $free_space_y   = '&frac15;c';
                    $free_space_x_w = $diag / 5;
                    $free_space_y_h = $diag / 5;
                }
                if ( $new_r > 5 && $new_r <= 6 ) {
                    // var c = Math.sqrt(this.logo_w*this.logo_w+this.logo_h*this.logo_h)/5
                    $free_space_x   = '&frac16;c';
                    $free_space_y   = '&frac16;c';
                    $free_space_x_w = $diag / 6;
                    $free_space_y_h = $diag / 6;
                }
                if ( $new_r > 6 && $new_r <= 8 ) {
                    // var c = Math.sqrt(this.logo_w*this.logo_w+this.logo_h*this.logo_h)/5
                    $free_space_x   = '&frac18;c';
                    $free_space_y   = '&frac18;c';
                    $free_space_x_w = $diag / 8;
                    $free_space_y_h = $diag / 8;
                }
                break;
        }

        return [ $show_clear_icon, $free_space_x_w, $free_space_y_h, $free_sp_x_text, $free_sp_y_text, $free_space_y, $free_space_x, $free_sp_c_text, $free_sp_y_text, $free_sp_x_text ];
    }

    public static function logoFreeSpace( &$data ) {

        $free_space_x   = 0;
        $free_space_y   = 0;
        $free_space_x_w = 0;
        $free_space_y_h = 0;

        $shorter      = 0;
        $longer       = 0;
        $shorter_text = 'x';
        $longer_text  = 'y';

        if ( $data->logo_w < $data->logo_h ) {
            $shorter = $data->logo_w;
            $longer  = $data->logo_h;
            if ( $longer > 140 ) {
                $longer       = 140;
                $shorter      = $shorter * 140 / $data->logo_h;
                $data->logo_h = 140;
                $data->logo_w = $shorter;
            }
            $shorter_text = 'x';
            $longer_text  = 'y';
        } elseif ( ceil( $data->logo_w ) == ceil( $data->logo_h ) ) {
            $shorter = $data->logo_h;
            $longer  = $data->logo_h;
            if ( $shorter > 200 ) {
                $shorter      = 140;
                $longer       = 140;
                $data->logo_h = 140;
                $data->logo_w = 140;
            }
            $shorter_text = 'x';
            $longer_text  = 'x';
        } else {
            $shorter = $data->logo_h;
            $longer  = $data->logo_w;
            if ( $longer > 200 ) {
                $longer       = 200;
                $shorter      = $shorter * 200 / $data->logo_w;
                $data->logo_w = 200;
                $data->logo_h = $shorter;
            }
            if ( $longer < 200 ) {
                $longer       = 200;
                $shorter      = $shorter * 200 / $data->logo_w;
                $data->logo_w = 200;
                $data->logo_h = $shorter;
            }
            $shorter_text = 'y';
            $longer_text  = 'x';
        }

        $new_r = $longer / $shorter;
        if ( $shorter != $longer ) {
            $free_sp_y_text = 'y';
            $free_sp_x_text = 'x';
        } else {
            $free_sp_y_text = 'x';
            $free_sp_x_text = 'x';
        }

        $free_space_x     = 'x';
        $free_space_y     = 'x';
        $free_sp_c_text   = '';
        $clear_space_text = '';
        $show_clear_icon  = false;
        switch ( $data->space ) {
            case 'newton':
                $show_clear_icon = false;
                if ( $new_r >= 1 && $new_r <= 1.6 ) {
                    $free_space_x   = '&frac13;' . $shorter_text;
                    $free_space_y   = '&frac13;' . $shorter_text;
                    $free_space_x_w = $shorter / 3;
                    $free_space_y_h = $shorter / 3;
                }
                if ( $new_r > 1.6 && $new_r <= 10 ) {
                    $free_space_x   = '&frac12;' . $shorter_text;
                    $free_space_y   = '&frac12;' . $shorter_text;
                    $free_space_x_w = $shorter / 2;
                    $free_space_y_h = $shorter / 2;
                }

                break;
            case 'hawkins':
                $show_clear_icon = false;
                if ( $new_r >= 1 && $new_r <= 1.6 ) {
                    $free_space_x   = '&frac12;' . $shorter_text;
                    $free_space_y   = '&frac12;' . $shorter_text;
                    $free_space_x_w = $shorter / 2;
                    $free_space_y_h = $shorter / 2;
                }
                if ( $new_r > 1.6 && $new_r <= 10 ) {
                    $free_space_x   = $shorter_text;
                    $free_space_y   = $shorter_text;
                    $free_space_x_w = $shorter;
                    $free_space_y_h = $shorter;
                }

                break;
            case 'einstein':
                $show_clear_icon = false;
                $free_sp_y_text  = 'y';
                $free_sp_x_text  = 'x';
                $free_sp_c_text  = '';
                if ( $new_r >= 1 && $new_r <= 1.39 ) {
                    $show_clear_icon = true;
                    if ( $shorter_text == 'x' ) {
                        $free_space_x   = '&frac23;' . $shorter_text;
                        $free_space_y   = '&frac23;' . $longer_text;
                        $free_space_x_w = $shorter * 2 / 3;
                        $free_space_y_h = $longer * 2 / 3;
                    } else {
                        $free_space_y   = '&frac23;' . $shorter_text;
                        $free_space_x   = '&frac23;' . $longer_text;
                        $free_space_y_h = $shorter * 2 / 3;
                        $free_space_x_w = $longer * 2 / 3;
                    }
                }
                if ( $new_r > 1.39 && $new_r <= 1.99 ) {
                    if ( $shorter_text == 'x' ) {
                        $free_space_x   = '&frac23;' . $shorter_text;
                        $free_space_y   = '&frac12;' . $longer_text;
                        $free_space_x_w = $shorter * 2 / 3;
                        $free_space_y_h = $longer / 2;
                    } else {
                        $free_space_y   = '&frac23;' . $shorter_text;
                        $free_space_x   = '&frac12;' . $longer_text;
                        $free_space_y_h = $shorter * 2 / 3;
                        $free_space_x_w = $longer / 2;
                    }
                }
                if ( $new_r > 1.99 && $new_r <= 2.99 ) {
                    if ( $shorter_text == 'x' ) {
                        $free_space_x   = '&frac23;' . $shorter_text;
                        $free_space_y   = '&frac13;' . $longer_text;
                        $free_space_x_w = $shorter * 2 / 3;
                        $free_space_y_h = $longer / 3;
                    } else {
                        $free_space_y   = '&frac23;' . $shorter_text;
                        $free_space_x   = '&frac13;' . $longer_text;
                        $free_space_y_h = $shorter * 2 / 3;
                        $free_space_x_w = $longer / 3;
                    }
                }
                if ( $new_r > 2.99 && $new_r <= 3.99 ) {
                    if ( $shorter_text == 'x' ) {
                        $free_space_x   = '&frac23;' . $shorter_text;
                        $free_space_y   = '&frac14;' . $longer_text;
                        $free_space_x_w = $shorter * 2 / 3;
                        $free_space_y_h = $longer / 4;
                    } else {
                        $free_space_y   = '&frac23;' . $shorter_text;
                        $free_space_x   = '&frac14;' . $longer_text;
                        $free_space_y_h = $shorter * 2 / 3;
                        $free_space_x_w = $longer / 4;
                    }
                }
                if ( $new_r > 3.99 && $new_r <= 4.99 ) {
                    if ( $shorter_text == 'x' ) {
                        $free_space_x   = '&frac23;' . $longer_text;
                        $free_space_y   = '&frac15;' . $shorter_text;
                        $free_space_x_w = $shorter * 2 / 3;
                        $free_space_y_h = $longer / 5;
                    } else {
                        $free_space_y   = '&frac23;' . $longer_text;
                        $free_space_x   = '&frac15;' . $shorter_text;
                        $free_space_y_h = $shorter * 2 / 3;
                        $free_space_x_w = $longer / 5;
                    }
                }
                if ( $new_r > 4.99 && $new_r <= 5.99 ) {
                    if ( $shorter_text == 'x' ) {
                        $free_space_x   = '&frac23;' + $shorter_text;
                        $free_space_y   = '&frac16;' + $longer_text;
                        $free_space_x_w = $shorter * 2 / 3;
                        $free_space_y_h = $longer / 6;
                    } else {
                        $free_space_y   = '&frac23;' . $shorter_text;
                        $free_space_x   = '&frac16;' . $longer_text;
                        $free_space_y_h = $shorter * 2 / 3;
                        $free_space_x_w = $longer / 6;
                    }
                }
                if ( $new_r > 5.99 && $new_r <= 6.99 ) {
                    if ( $shorter_text == 'x' ) {
                        $free_space_x   = '&frac23;' . $shorter_text;
                        $free_space_y   = '&frac17;' . $longer_text;
                        $free_space_x_w = $shorter * 2 / 3;
                        $free_space_y_h = $longer / 7;
                    } else {
                        $free_space_y   = '&frac23;' . $shorter_text;
                        $free_space_x   = '&frac17;' . $longer_text;
                        $free_space_y_h = $shorter * 2 / 3;
                        $free_space_x_w = $longer / 7;
                    }
                }
                if ( $new_r > 6.99 && $new_r <= 7.99 ) {
                    if ( $shorter_text == 'x' ) {
                        $free_space_x   = '&frac23;' . $shorter_text;
                        $free_space_y   = '&frac18;' . $longer_text;
                        $free_space_x_w = $shorter * 2 / 3;
                        $free_space_y_h = $longer / 8;
                    } else {
                        $free_space_y   = '&frac23;' . $shorter_text;
                        $free_space_x   = '&frac18;' . $longer_text;
                        $free_space_y_h = $shorter * 2 / 3;
                        $free_space_x_w = $longer / 8;
                    }
                }
                break;
            case 'pithagoras':
                $free_sp_y_text   = 'y';
                $free_sp_c_text   = 'c';
                $free_sp_x_text   = 'x';
                $show_clear_icon  = false;
                $clear_space_text = 'X&sup2; + Y&sup2; = C&sup2;';
                $diag             = sqrt( $shorter * $shorter + $longer * $longer );
                if ( $new_r >= 1 && $new_r <= 1.5 ) {
                    $free_space_x   = '&frac12;c';
                    $free_space_y   = '&frac12;c';
                    $free_space_x_w = $diag / 2;
                    $free_space_y_h = $diag / 2;
                }
                if ( $new_r > 1.5 && $new_r <= 3 ) {
                    $free_space_x   = '&frac13;c';
                    $free_space_y   = '&frac13;c';
                    $free_space_x_w = $diag / 3;
                    $free_space_y_h = $diag / 3;
                }
                if ( $new_r > 3 && $new_r <= 4 ) {
                    $free_space_x   = '&frac14;c';
                    $free_space_y   = '&frac14;c';
                    $free_space_x_w = $diag / 4;
                    $free_space_y_h = $diag / 4;
                }
                if ( $new_r > 4 && $new_r <= 5 ) {
                    $free_space_x   = '&frac15;c';
                    $free_space_y   = '&frac15;c';
                    $free_space_x_w = $diag / 5;
                    $free_space_y_h = $diag / 5;
                }
                if ( $new_r > 5 && $new_r <= 6 ) {
                    $free_space_x   = '&frac16;c';
                    $free_space_y   = '&frac16;c';
                    $free_space_x_w = $diag / 6;
                    $free_space_y_h = $diag / 6;
                }
                if ( $new_r > 6 && $new_r <= 8 ) {
                    $free_space_x   = '&frac18;c';
                    $free_space_y   = '&frac18;c';
                    $free_space_x_w = $diag / 8;
                    $free_space_y_h = $diag / 8;
                }
                break;
        }
        $logo_fsy = 3 * $free_space_y_h + $data->logo_h;

        return compact( 'clear_space_text',
            'free_space_y_h',
            'free_space_x_w',
            'show_clear_icon',
            'free_space_y', 'free_space_x', 'free_sp_x_text', 'free_sp_y_text', 'free_sp_c_text' );
    }
}
