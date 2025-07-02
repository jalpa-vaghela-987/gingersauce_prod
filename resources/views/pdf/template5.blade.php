@php

    if(
        $data->icon == '[]' ||
        $data->icon == 'skipped'
    ){
        $data->icon = null;
    }

    $white_bg_logo = $data->logo_b64;
    if(
        optional($data->logo_versions[0])->white_bg_logo_type == 'white' &&
        ($white_bg_logo_object = optional($data->logo_versions[0])->white_bg_logo)
    ){
        $white_bg_logo = $white_bg_logo_object->logo_b64;
    }

    if (!class_exists('ThemeHelper')) {
    class ThemeHelper
    {
        const LOGO_VARIATIONS_ORDER = [
            0 => 'alt1',
            1 => '0_White Negative on Primary',
            2 => 'alt2',
            3 => '1_White Negative on Primary',
            4 => '2_White Negative on Primary',
            5 => '0_Primary Color Positive',
            6 => '0_Primary & Colors',
            7 => '0_Primary & Black',
            8 => '0_White Negative',
            9 => '0_Secondary Color Positive',
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

        const MINIMUM_SIZES_LOGO = [
            'quark' => [
                'px' => 71,
                'mm' => 20,
            ],
            'neutron' => [
                'px' => 100,
                'mm' => 28,
            ],
            'atom' => [
                'px' => 160,
                'mm' => 45,
            ],
            'molecule' => [
                'px' => 214,
                'mm' => 60,
            ],
        ];

        const MINIMUM_SIZES_ICON = [
            'quark' => [
                'px' => 10,
                'mm' => 2.8,
            ],
            'neutron' => [
                'px' => 14,
                'mm' => 3.9,
            ],
            'atom' => [
                'px' => 22,
                'mm' => 6.3,
            ],
            'molecule' => [
                'px' => 30,
                'mm' => 8.4,
            ],
        ];

        public $data;
        public $logo_clear_space = null;
        public $icon_clear_space = null;
        public $logo_dimentions = [];
        public $icon_dimentions = [];

        public $logo_proportions;
        public $icon_proportions;

        public $primary_color;
        public $secondary_color;

        public $mockupIndex = 0;

        public $pageNumbers = [
            'bookIntro' => 0,
            'bookLogo' => 0,
            'bookGuidelines' => 0,
            'colorPalette' => 0,
            'bookFont' => 0
        ];

        public function __construct($data, $brandbook = null)
        {
            $this->data = $data;

            if($this->logo_dimentions = $this->detectImageDimention($this->data->logo)){
                $this->logo_clear_space = $this->calculate_clear_space_data(
                    $this->logo_dimentions,
                    [
                        'limit_w' => 200,
                        'limit_h' => 140
                    ]
                );
            }

            if($this->icon_dimentions = $this->detectImageDimention($this->data->icon)){
                $this->icon_clear_space = $this->calculate_clear_space_data(
                    $this->icon_dimentions,
                    [
                        'limit_w' => 100,
                        'limit_h' => 60
                    ]
                );
            }

            $this->primary_color = $this->data->colors_list[0]->id;
            $this->secondary_color = $this->data->colors_list[1]->id;

            $this->logo_proportions = $this->getProportionData($this->data->logo);
            $this->icon_proportions = $this->getProportionData($this->data->icon);
        }

        public function pagesFor($chapter, $page)
        {
            $pages = [
                'left' => $page+1,
                'right' => $page+2
            ];

            if(array_key_exists($chapter, $this->pageNumbers)){
                $this->pageNumbers[$chapter] = sprintf('%02d', $pages['left']);
            }

            return $pages;
        }

        private static function detectImageDimention($image)
        {
            if (
                empty( $image ) &&
                $image == 'skipped' &&
                $image == '[]'
            ){
                return null;
            }

            if(
                ($width = self::svgGetValue('width', $image)) &&
                ($height = self::svgGetValue('height', $image))
            ){
                return compact('width', 'height');
            }elseif($dimentions = self::svgParseViewboxParamForDimentions($image)){
                return $dimentions;
            }else{
                return null;
            }
        }

        private static function svgGetValue($valueName, $source)
        {
            $pattern = '/' . $valueName . '="[0-9a-z.]+"/m';
            $matches = [];
            if(preg_match($pattern, $source,  $matches)){
                $match = $matches[0];
                $value = str_replace(['"', '=', 'px', $valueName], "", $match);

                return intval($value);
            }else{
                return null;
            }
        }

        private static function svgParseViewboxParamForDimentions($source)
        {
            // Detecting SVG-image dimentions by parsing viewBox params which has
            // the following pattern: viewBox="0 0 100 100"

            $pattern = '/viewBox="[0-9. -]+"/m';
            $matches = [];
            if(preg_match($pattern, $source,  $matches)){
                $match = $matches[0];
                $viewboxDimentions = str_replace(['"', '=', 'viewBox'], "", $match);
                $plainDimentions = explode(' ', $viewboxDimentions);
                if(count($plainDimentions) == 4){
                    $width = intval($plainDimentions[2]) - intval($plainDimentions[0]);
                    $height = intval($plainDimentions[3]) - intval($plainDimentions[1]);
                    if($width && $height){
                        return compact('width', 'height');
                    }else{
                        return null;
                    }
                }else{
                    return null;
                }
            }else{
                return null;
            }
        }

        public static function adjustBrightness($hex, $steps) {
            // Steps should be between -255 and 255. Negative = darker, positive = lighter
            $steps = max(-255, min(255, $steps));

            // Normalize into a six character long hex string
            $hex = str_replace('#', '', $hex);
            if (strlen($hex) == 3) {
                $hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
            }

            // Split into three parts: R, G and B
            $color_parts = str_split($hex, 2);
            $return = '#';

            foreach ($color_parts as $color) {
                $color   = hexdec($color); // Convert to decimal
                $color   = max(0,min(255,$color + $steps)); // Adjust color
                $return .= str_pad(dechex($color), 2, '0', STR_PAD_LEFT); // Make two char hex code
            }

            return $return;
        }

        public function colorRGBA($num, $alpha)
        {
            return "rgba(
                    {$this->data->colors_list[$num]->color->rgb->r},
                    {$this->data->colors_list[$num]->color->rgb->g},
                    {$this->data->colors_list[$num]->color->rgb->b},
                    {$alpha}
                );";
        }

        public function orderLogoVariations($approved, $logo_versions)
        {
            $ordered = [];

            foreach (self::LOGO_VARIATIONS_ORDER as $item ){

                if ( 'alt1' == $item && !empty( $logo_versions[ 1 ] ) ){
                    $logo_versions[ 1 ]->background = 'transparent';
                    $logo_versions[ 1 ]->id         = 'alt1';
                    $ordered[]                      = $logo_versions[ 1 ];
                    continue;
                }

                if ( 'alt2' == $item && !empty( $logo_versions[ 2 ] ) ){
                    $logo_versions[ 2 ]->background = 'transparent';
                    $logo_versions[ 2 ]->id         = 'alt1';
                    $ordered[] = $logo_versions[ 2 ];
                    continue;
                }

                foreach ( $approved as $approved_item ){
                    if ( $item == $approved_item->id ){
                        $ordered[] = $approved_item;
                    }
                }
            }

            return collect($ordered)->chunk(4);
        }

        public static function from_camel_case($input)
        {
            preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
            $ret = $matches[0];
            foreach ($ret as &$match) {
                $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
            }

            return implode('-', $ret);
        }

        public function getProportionData($svg)
        {
            $data = $this->data;
            $dimentions = $this->detectImageDimention($svg);
            if(!$dimentions){
                return null;
            }
            $width = $dimentions['width'];
            $height = $dimentions['height'];

            if($width==0){
                $width = 200;
            }

            if($height==0){
                $height = 100;
            }

            $ratio = floatval($width / ($height==0?1:$height));
            $proportions_x = 'x';
            $proportions_y = 'x';
            $proportions_text = '';

            $proportions_fibo_active_active = false;

            $prop_x_val = $ratio - floor($ratio)>0.1 ?
                number_format($ratio, 1) :
                round($ratio);

            if($prop_x_val - floor($prop_x_val)<0.1){
                $prop_x_val = floor($prop_x_val);
            }

            switch($data->proportions){
                case 'leonardo':

                    if($ratio>1){
                        $proportions_x = $prop_x_val.'x';
                        if($proportions_x == '1x')
                            $proportions_x = 'x';
                        $proportions_y = 'x';
                    }else{
                        $prop_x_val = ((1/$ratio) - floor(1/$ratio)>0.1?number_format(1/$ratio, 1):round(1/$ratio));
                        if($prop_x_val - floor($prop_x_val)<0.1)
                            $prop_x_val = floor($prop_x_val);
                        $proportions_y = $prop_x_val.'x';
                        if($proportions_y == '1x')
                            $proportions_y = 'x';
                        $proportions_x = 'x';
                    }
                    $proportions_fibo_active_active = false;
                    break;
                case 'michaelangelo':
                    if($ratio>1){
                        $proportions_y = '1/'.$prop_x_val.'x';
                        if($proportions_y == '1/3x')
                            $proportions_y = '&frac13;x';
                        if($proportions_y == '1/2x')
                            $proportions_y = '&frac12;x';
                        if($proportions_y == '1/4x')
                            $proportions_y = '&frac14;x';
                        if($proportions_y == '1/5x')
                            $proportions_y = '&frac15;x';
                        if($proportions_y == '1/6x')
                            $proportions_y = '&frac16;x';
                        if($proportions_y == '1/7x')
                            $proportions_y = '&frac17;x';
                        if($proportions_y == '1/8x')
                            $proportions_y = '&frac18;x';
                        if($proportions_y == '1x')
                            $proportions_y = 'x';
                        $proportions_x = 'x';
                    }else{
                        $proportions_x = $prop_x_val.'x';
                        if($proportions_x == '1x')
                            $proportions_x = 'x';
                        $proportions_y = 'x';
                    }
                    $proportions_fibo_active_active = false;

                    break;
                case 'fibonacci':

                    $proportions_fibo_active_active = true;
                    if($ratio>=.613 && $ratio<=.86){
                        $proportions_x = 'x';
                        $proportions_y = '1.618 x';
                    }else{
                        if($ratio>1){
                            $proportions_x = $prop_x_val.'x';
                            if($proportions_x == '1x')
                                $proportions_x = 'x';
                            $proportions_y = 'x';
                        }else{
                            $prop_x_val = ((1/$ratio) - floor(1/$ratio)>0.1?number_format(1/$ratio, 1):round(1/$ratio));
                            if($prop_x_val - floor($prop_x_val)<0.1)
                                $prop_x_val = floor($prop_x_val);
                            $proportions_y = $prop_x_val.'x';
                            if($proportions_y == '1x')
                                $proportions_y = 'x';
                            $proportions_x = 'x';
                        }
                    }

                    break;
                case 'vitruvious':
                    if($ratio>1){
                        $proportions_x = ceil(floatval($ratio)).'x';
                        $proportions_y = 'x';
                    }else{
                        $proportions_y = ceil(floatval($ratio)).'x';
                        $proportions_x = 'x';
                    }
                    break;
            }
            $proportions_fibo_active_golden = false;
            // $proportions_fibo_active_active = false;
            $proportions_fibo_active = [];
            $proportions_text_small='';

            if($ratio>=0.95 && $ratio<=1.05){
                $proportions_text = '1:1 ' . trans('themes.square_ratio');
                $proportions_text_small = $proportions_text;
                if($data->proportions == 'fibonacci')
                    $proportions_text.="<br>" . trans('themes.prop_linked_to_fib_seq');
                $proportions_fibo_active[]=1;
            }else if($ratio>=2.9 && $ratio<=3.1){
                $proportions_text = '1:3 ' . trans('themes.ratio');
                $proportions_text_small = $proportions_text;
                if($data->proportions == 'fibonacci')
                    $proportions_text.="<br>" . trans('themes.prop_linked_to_fib_seq');
                $proportions_fibo_active[]=3;
            }else if($ratio>=4.8 && $ratio<=5.2){
                $xval = (floatval($proportions_x) > 0) ? floatval($proportions_x) : 1;
                $proportions_text = '1:'.$xval.' '  . trans('themes.ratio');
                $proportions_text_small = $proportions_text;
                if($data->proportions == 'fibonacci')
                    $proportions_text.="<br>" . trans('themes.prop_linked_to_fib_seq');
                $proportions_fibo_active[]=5;
            }else if($ratio>=7.8 && $ratio<=8.2){
                $proportions_text = '1:8 '  . trans('themes.ratio');
                $proportions_text_small = $proportions_text;
                if($data->proportions == 'fibonacci')
                    $proportions_text.="<br>" . trans('themes.prop_linked_to_fib_seq');
                $proportions_fibo_active[]=8;
            }else if($ratio>=1.4 && $ratio<=1.58){
                $proportions_text = '2:3 Ratio';
                $proportions_text_small = $proportions_text;
                if($data->proportions == 'fibonacci')
                    $proportions_text.="<br>" . trans('themes.prop_linked_to_fib_seq');
                $proportions_fibo_active[]=2;
                $proportions_fibo_active[]=3;
            }else if($ratio>=1.641 && $ratio<=1.7){
                $proportions_text = '3:5 '  . trans('themes.ratio');
                $proportions_text_small = $proportions_text;
                if($data->proportions == 'fibonacci')
                    $proportions_text.="<br>" . trans('themes.prop_linked_to_fib_seq');
                $proportions_fibo_active[]=3;
                $proportions_fibo_active[]=5;
            }else if($ratio>=1.581 && $ratio<=1.64){
                $proportions_text = '1:1.681 ' . trans('themes.golden_ratio');
                $proportions_text_small = $proportions_text;
                if($data->proportions == 'fibonacci')
                    $proportions_text.="<br>" . trans('themes.prop_linked_to_fib_seq');
                $proportions_fibo_active_golden = true;
            }else{
                $xx = floatval($proportions_x);
                $yy = floatval($proportions_y);
                if(is_nan($xx) || $xx==0)
                    $xx = 1;
                if(is_nan($yy) || $yy==0)
                    $yy = 1;

                if(strpos($proportions_x, '/')){
                    $xx = str_replace('x', '', str_replace('y', '', $proportions_x));
                }
                if(strpos($proportions_y, '/')){
                    $yy = str_replace('x', '', str_replace('y', '', $proportions_y));
                }

                if($proportions_x=='&frac12;x'){
                    $xx=1;
                    $yy=2;
                }
                if($proportions_x=='&frac13;x'){
                    $xx=1;
                    $yy=3;
                }
                if($proportions_x=='&frac14;x'){
                    $xx=1;
                    $yy=4;
                }
                if($proportions_x=='&frac15;x'){
                    $xx=1;
                    $yy=5;
                }
                if($proportions_x=='&frac16;x'){
                    $xx=1;
                    $yy=6;
                }
                if($proportions_x=='&frac17;x'){
                    $xx=1;
                    $yy=7;
                }
                if($proportions_x=='&frac18;x'){
                    $xx=1;
                    $yy=8;
                }

                if($proportions_y=='&frac12;x'){
                    $xx=1;
                    $yy=2;
                }
                if($proportions_y=='&frac13;x'){
                    $xx=1;
                    $yy=3;
                }
                if($proportions_y=='&frac14;x'){
                    $xx=1;
                    $yy=4;
                }
                if($proportions_y=='&frac15;x'){
                    $xx=1;
                    $yy=5;
                }
                if($proportions_y=='&frac16;x'){
                    $xx=1;
                    $yy=6;
                }
                if($proportions_y=='&frac17;x'){
                    $xx=1;
                    $yy=7;
                }
                if($proportions_y=='&frac18;x'){
                    $xx=1;
                    $yy=8;
                }


                $proportions_text = $xx.':'.$yy.' Ratio';
                $proportions_text_small = $xx.':'.$yy;
            }

            return [
                'width' => $width,
                'height' => $height,
                'orientation' => $width > $height ? 'flat' : 'tall',
                'proportions_text_small' => $proportions_text_small,
                'proportions_x' => $proportions_x,
                'proportions_y' => $proportions_y,
                'ratio' => $ratio,
                'proportions_text' => $proportions_text,
                'proportions_fibo_active_active' => $proportions_fibo_active_active,
            ];
        }

        public function proportionImages()
        {
            $images = [];
            $images['logo'] = [
                'svg' => $this->data->logo,
                'image' => $this->logo('0_Black & White Positive', true),
                'proportions_x' => Arr::get($this->logo_proportions, 'proportions_x', 'x'),
                'proportions_y' => Arr::get($this->logo_proportions, 'proportions_y', 'y'),
                'orientation' => Arr::get($this->logo_proportions, 'orientation', 'flat')
            ];

            if($this->data->icon){
                $images['icon'] = [
                    'svg' => $this->data->icon,
                    'image' => $this->icon('Black & White Positive', true),
                    'proportions_x' => Arr::get($this->icon_proportions, 'proportions_x', 'x'),
                    'proportions_y' => Arr::get($this->icon_proportions, 'proportions_y', 'y'),
                    'orientation' => Arr::get($this->icon_proportions, 'orientation', 'flat')
                ];
            }

            return $images;
        }

        public function minimumSize($type = 'logo')
        {
            $size = $this->data->size;
            $sizes = $type == 'logo' ?
                self::MINIMUM_SIZES_LOGO :
                self::MINIMUM_SIZES_ICON;

            if(!array_key_exists($size, $sizes)){
                return null;
            }

            $result = $sizes[$size];

            $result['text'] = __("The :brand {$type} should never be smaller than
                :size_px px in digital or :size_mm mm in print.", [
                    'size_px' => $result['px'],
                    'size_mm' => $result['mm'],
                    'brand' => $this->data->brand
                ]);

            $result['image'] = $type == 'icon' ?
                $this->data->icon_b64 :
                'white_bg_logo';

            if(!$result['image']){
                return null;
            }

            return $result;
        }

        protected function calculate_clear_space_data($dimentions, $limits = null)
        {
            $image_w = $dimentions['width'];
            $image_h = $dimentions['height'];

            if(!$limits){
                $limits = [
                    'limit_w' => 200,
                    'limit_h' => 140,
                ];
            }

            $free_space_x = 0;
            $free_space_y = 0;
            $free_space_x_w = 0;
            $free_space_y_h = 0;

            $shorter = 0;
            $longer = 0;
            $shorter_text = 'x';
            $longer_text = 'y';

            if($image_w<$image_h){
                $shorter = $image_w;
                $longer = $image_h;
                if($longer>$limits['limit_h']){
                    $longer = $limits['limit_h'];
                    $shorter = $shorter*$limits['limit_h']/$image_h;
                    $image_h = $limits['limit_h'];
                    $image_w = $shorter;
                }
                $shorter_text = 'x';
                $longer_text = 'y';
            }elseif(ceil($image_w)==ceil($image_h)){
                $shorter = $image_h;
                $longer = $image_h;
                if($shorter>$limits['limit_w']){
                    $shorter = $limits['limit_h'];
                    $longer = $limits['limit_h'];
                    $image_h = $limits['limit_h'];
                    $image_w = $limits['limit_h'];
                }
                $shorter_text = 'x';
                $longer_text = 'x';
            }else{
                $shorter = $image_h;
                $longer = $image_w;
                if($longer>$limits['limit_w']){
                    $longer = $limits['limit_w'];
                    $shorter = $shorter*$limits['limit_w']/$image_w;
                    $image_w = $limits['limit_w'];
                    $image_h = $shorter;
                }
                if($longer<$limits['limit_w']){
                    $longer = $limits['limit_w'];
                    $shorter = $shorter*$limits['limit_w']/$image_w;
                    $image_w = $limits['limit_w'];
                    $image_h = $shorter;
                }
                $shorter_text = 'y';
                $longer_text = 'x';
            }

            $new_r = $longer / $shorter;
            if($shorter != $longer){
                $free_sp_y_text = 'y';
                $free_sp_x_text = 'x';
            }else{
                $free_sp_y_text = 'x';
                $free_sp_x_text = 'x';
            }

            $free_space_x = 'x';
            $free_space_y = 'x';
            $free_sp_c_text = '';
            $clear_space_text = '';
            $show_clear_icon = false;

            if(!$this->data->space){
                $this->data->space = 'newton';
            }

            switch($this->data->space){
                case 'newton':
                    $show_clear_icon = false;
                    if($new_r>=1 && $new_r<=1.6){
                        $free_space_x = '&frac13;'.$shorter_text;
                        $free_space_y = '&frac13;'.$shorter_text;
                        $free_space_x_w = $shorter/3;
                        $free_space_y_h = $shorter/3;
                    }
                    if($new_r>1.6 && $new_r<=10){
                        $free_space_x = '&frac12;'.$shorter_text;
                        $free_space_y = '&frac12;'.$shorter_text;
                        $free_space_x_w = $shorter/2;
                        $free_space_y_h = $shorter/2;
                    }
                    break;
                case 'hawkins':
                    $show_clear_icon = false;
                    if($new_r>=1 && $new_r<=1.6){
                        $free_space_x = '&frac12;'.$shorter_text;
                        $free_space_y = '&frac12;'.$shorter_text;
                        $free_space_x_w = $shorter/2;
                        $free_space_y_h = $shorter/2;
                    }
                    if($new_r>1.6 && $new_r<=10){
                        $free_space_x = $shorter_text;
                        $free_space_y = $shorter_text;
                        $free_space_x_w = $shorter;
                        $free_space_y_h = $shorter;
                    }
                    break;
                case 'einstein':
                    $show_clear_icon = false;
                    $free_sp_y_text = 'y';
                    $free_sp_x_text = 'x';
                    $free_sp_c_text = '';
                    if($new_r>=1 && $new_r<=1.39){
                        $show_clear_icon = true;
                        if($shorter_text == 'x'){
                            $free_space_x = '&frac23;'.$shorter_text;
                            $free_space_y = '&frac23;'.$longer_text;
                            $free_space_x_w = $shorter*2/3;
                            $free_space_y_h = $longer*2/3;
                        }else{
                            $free_space_y = '&frac23;'.$shorter_text;
                            $free_space_x = '&frac23;'.$longer_text;
                            $free_space_y_h = $shorter*2/3;
                            $free_space_x_w = $longer*2/3;
                        }
                    }
                    if($new_r>1.39 && $new_r<=1.99){
                        if($shorter_text == 'x'){
                            $free_space_x = '&frac23;'.$shorter_text;
                            $free_space_y = '&frac12;'.$longer_text;
                            $free_space_x_w = $shorter*2/3;
                            $free_space_y_h = $longer/2;
                        }else{
                            $free_space_y = '&frac23;'.$shorter_text;
                            $free_space_x = '&frac12;'.$longer_text;
                            $free_space_y_h = $shorter*2/3;
                            $free_space_x_w = $longer/2;
                        }
                    }
                    if($new_r>1.99 && $new_r<=2.99){
                        if($shorter_text == 'x'){
                            $free_space_x = '&frac23;'.$shorter_text;
                            $free_space_y = '&frac13;'.$longer_text;
                            $free_space_x_w = $shorter*2/3;
                            $free_space_y_h = $longer/3;
                        }else{
                            $free_space_y = '&frac23;'.$shorter_text;
                            $free_space_x = '&frac13;'.$longer_text;
                            $free_space_y_h = $shorter*2/3;
                            $free_space_x_w = $longer/3;
                        }
                    }
                    if($new_r>2.99 && $new_r<=3.99){
                        if($shorter_text == 'x'){
                            $free_space_x = '&frac23;'.$shorter_text;
                            $free_space_y = '&frac14;'.$longer_text;
                            $free_space_x_w = $shorter*2/3;
                            $free_space_y_h = $longer/4;
                        }else{
                            $free_space_y = '&frac23;'.$shorter_text;
                            $free_space_x = '&frac14;'.$longer_text;
                            $free_space_y_h = $shorter*2/3;
                            $free_space_x_w = $longer/4;
                        }
                    }
                    if($new_r>3.99 && $new_r<=4.99){
                        if($shorter_text == 'x'){
                            $free_space_x = '&frac23;'.$longer_text;
                            $free_space_y = '&frac15;'.$shorter_text;
                            $free_space_x_w = $shorter*2/3;
                            $free_space_y_h = $longer/5;
                        }else{
                            $free_space_y = '&frac23;'.$longer_text;
                            $free_space_x = '&frac15;'.$shorter_text;
                            $free_space_y_h = $shorter*2/3;
                            $free_space_x_w = $longer/5;
                        }
                    }
                    if($new_r>4.99 && $new_r<=5.99){
                        if($shorter_text == 'x'){
                            $free_space_x = '&frac23;'+$shorter_text;
                            $free_space_y = '&frac16;'+$longer_text;
                            $free_space_x_w = $shorter*2/3;
                            $free_space_y_h = $longer/6;
                        }else{
                            $free_space_y = '&frac23;'.$shorter_text;
                            $free_space_x = '&frac16;'.$longer_text;
                            $free_space_y_h = $shorter*2/3;
                            $free_space_x_w = $longer/6;
                        }
                    }
                    if($new_r>5.99 && $new_r<=6.99){
                        if($shorter_text == 'x'){
                            $free_space_x = '&frac23;'.$shorter_text;
                            $free_space_y = '&frac17;'.$longer_text;
                            $free_space_x_w = $shorter*2/3;
                            $free_space_y_h = $longer/7;
                        }else{
                            $free_space_y = '&frac23;'.$shorter_text;
                            $free_space_x = '&frac17;'.$longer_text;
                            $free_space_y_h = $shorter*2/3;
                            $free_space_x_w = $longer/7;
                        }
                    }
                    if($new_r>6.99 && $new_r<=7.99){
                        if($shorter_text == 'x'){
                            $free_space_x = '&frac23;'.$shorter_text;
                            $free_space_y = '&frac18;'.$longer_text;
                            $free_space_x_w = $shorter*2/3;
                            $free_space_y_h = $longer/8;
                        }else{
                            $free_space_y = '&frac23;'.$shorter_text;
                            $free_space_x = '&frac18;'.$longer_text;
                            $free_space_y_h = $shorter*2/3;
                            $free_space_x_w = $longer/8;
                        }
                    }
                    break;
                case 'pithagoras':
                    $free_sp_y_text = 'y';
                    $free_sp_c_text = 'c';
                    $free_sp_x_text = 'x';
                    $show_clear_icon = false;
                    $clear_space_text = 'X&sup2; + Y&sup2; = C&sup2;';
                    $diag = sqrt($shorter*$shorter + $longer*$longer);
                    if($new_r>=1 && $new_r<=1.5){
                        $free_space_x = '&frac12;c';
                        $free_space_y = '&frac12;c';
                        $free_space_x_w = $diag/2;
                        $free_space_y_h = $diag/2;
                    }
                    if($new_r>1.5 && $new_r<=3){
                        $free_space_x = '&frac13;c';
                        $free_space_y = '&frac13;c';
                        $free_space_x_w = $diag/3;
                        $free_space_y_h = $diag/3;
                    }
                    if($new_r>3 && $new_r<=4){
                        $free_space_x = '&frac14;c';
                        $free_space_y = '&frac14;c';
                        $free_space_x_w = $diag/4;
                        $free_space_y_h = $diag/4;
                    }
                    if($new_r>4 && $new_r<=5){
                        $free_space_x = '&frac15;c';
                        $free_space_y = '&frac15;c';
                        $free_space_x_w = $diag/5;
                        $free_space_y_h = $diag/5;
                    }
                    if($new_r>5 && $new_r<=6){
                        $free_space_x = '&frac16;c';
                        $free_space_y = '&frac16;c';
                        $free_space_x_w = $diag/6;
                        $free_space_y_h = $diag/6;
                    }
                    if($new_r>6 && $new_r<=8){
                        $free_space_x = '&frac18;c';
                        $free_space_y = '&frac18;c';
                        $free_space_x_w = $diag/8;
                        $free_space_y_h = $diag/8;
                    }
                    break;
                }

            $logo_fsy = 3*$free_space_y_h + $image_h;

            return [
                'free_space_x' => $free_space_x,
                'free_sp_x_text' => $free_sp_x_text,
                'free_space_y' => $free_space_y,
                'free_sp_y_text' => $free_sp_y_text,
                'free_sp_c_text' => $free_sp_c_text,
                'clear_space_text' => $clear_space_text,
                'free_space_x_w' => $free_space_x_w,
                'free_space_y_h' => $free_space_y_h,
                'image_w' => $image_w,
                'image_h' => $image_h,
                'show_clear_icon' => $show_clear_icon
            ];
        }

        public function clearSpaceImages()
        {
            $images = [];
            if($this->logo_clear_space){
                $images['logo'] = [
                    'svg' => $this->data->logo,
                    'image' => $this->logo('0_Secondary Color Positive', true),
                    'space' => $this->logo_clear_space
                ];
            }

            if($this->icon_clear_space){
                $images['icon'] = [
                    'svg' => $this->data->icon,
                    'image' => $this->icon('Secondary Color Positive', true),
                    'space' => $this->icon_clear_space
                ];
            }

            return $images;
        }

        public function logo($key = null, $b64 = false)
        {
            $variations = $this->data->all_logo_variations;
            if(!is_array($variations)){
                $variations = json_decode($variations);
            }
            if($key && $variations && count($variations) && array_key_exists($key, $variations)){
                $logo = $this->data->all_logo_variations[$key];
                return $b64 ? $logo['logo_b64'] : $logo;
            }else{
                return $b64 ? $this->data->logo_b64 : $this->data->logo;
            }
        }

        public function icon($key = null, $b64 = false)
        {
            $variations = $this->data->all_icon_variations;
            if(!is_array($variations)){
                $variations = json_decode($variations);
            }
            if($key && $variations && count($variations) && array_key_exists($key, $variations)){
                $icon = $this->data->all_icon_variations[$key];
                return $b64 ? $icon['icon_b64'] : $icon;
            }else{
                return $b64 ? $this->data->icon_b64 : $this->data->icon;
            }
        }

        public function fontFaceStyles()
        {
            $result = '';
            $keys = [
                'main' => $this->data->fonts_main,
                'secondary' => $this->data->fonts_secondary
            ];

            foreach($keys as $key => $fonts){
                if(!$fonts || $fonts == '[]'){
                    continue;
                }
                foreach($fonts as $font_m){
                    if(!$font_m || !array_key_exists('file', $font_m)){
                        continue;
                    }
                    if(!isset($font_m['index'])){
                        $font_m['index'] = 1;
                    }
                    $index = $font_m['index'];
                    $name = $key . $index;
                    $fontUrl = (strpos($font_m['file'], 'http') !== false) ?
                        $font_m['file'] :
                        url($font_m['file']);

                    $result .= "
                        @font-face {
                            font-display: swap;
                            font-family: '{$name}';
                            src: url('{$fontUrl}');
                        }
                        .{$name} {
                            font-family: '{$name}';
                        }
                    ";
                }
            }

            return $result;
        }

        public function fonts()
        {
            $fonts = [];

            if(count($this->data->fonts_main)){
            $fonts['main'] = [
                    'fonts' => $this->data->fonts_main,
                    'text' => __('themes.primary_font'),
                    'class' => 'primary_color',
                    'name' => $this->data->fonts_main[1]['font_face']
                ];
            }

            if(count($this->data->fonts_secondary)){
                $fonts['secondary'] = [
                    'fonts' => $this->data->fonts_secondary,
                    'text' => trans('themes.secondary_font'),
                    'class' => 'secondary_color',
                    'name' => $this->data->fonts_secondary[1]['font_face']
                ];
            }

            return $fonts;
        }

        public function adjustPageNumberForMockups($page)
        {
            if(isset($this->data->mockups[$this->mockupIndex])){
                $this->mockupIndex++;
                $page += 2;
            }

            return $page;
        }

        public function featureIconGridClass()
        {
            if(count($this->data->icon_family) >= 7) return 'grid_12';
            if(count($this->data->icon_family) >= 3) return 'grid_6';
            return 'grid_2';
        }

        public function getContrastColor($color)
        {
            return (new Mexitek\PHPColors\Color($color))->isDark() ? 'white' : 'black';
        }
    }
    }
    $themeHelper = new ThemeHelper($data);

    $page = 3;
@endphp

<html>
<head>
    @if(!empty($data->custom['body_family']))
        <link
                href="https://fonts.googleapis.com/css?family={{$data->custom['body_family']}}:{{$data->custom['body_weight']}}&display=swap"
                rel="stylesheet">
    @endif

    @if(!empty($data->custom['title_family']))
        <link
                href="https://fonts.googleapis.com/css?family={{$data->custom['title_family']}}:{{$data->custom['title_weight']}}&display=swap"
                rel="stylesheet">
    @endif
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <style>
        @font-face {
            font-family: 'Helvetica';
            src: url('{{ url('/fonts/helr45w.eot') }}'),
            url('{{ url('/fonts/helvetica/helr45w.woff') }}') format('woff'),
            url('{{ url('/fonts/helvetica/helr45w.ttf') }}') format('truetype'),
            url('{{ url('/fonts/helr45w.svg') }}') format('svg');
            font-weight: 400;
            font-style: normal;
        }

        @font-face {
            font-family: 'Helvetica';
            src: url('{{ url('/fonts/helr45w.eot') }}'),
            url('{{ url('/fonts/helvetica/helr45w.woff') }}') format('woff'),
            url('{{ url('/fonts/helvetica/helr45w.ttf') }}') format('truetype'),
            url('{{ url('/fonts/helr45w.svg') }}') format('svg');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'Helvetica';
            src: url('{{ url('/fonts/helvetica/helr65w.eot') }}'),
            url('{{ url('/fonts/helvetica/helr65w.woff') }}') format('woff'),
            url('{{ url('/fonts/helvetica/helr65w.ttf') }}') format('truetype'),
            url('{{ url('/fonts/helvetica/helr65w.svg') }}') format('svg');
            font-weight: 700;
            font-style: normal;
        }

        html, body {
            margin: 0;
            padding: 0;
            font-weight: normal;
            background: white;
            font-family: 'Helvetica';
        }

        .custom_title, .title {
            @if(!empty($data->custom['title_family']))
                  font-family: '{{ $data->custom['title_family'] }}', {{ $data->custom['title_category'] }}     !important;
            font-weight: {{ $data->custom['title_weight'] }}   !important;
            @if(strpos($data->custom['title_weight'], 'italic'))
  font-style: italic;
        @endif
    @endif




        }

        .custom_text, .text {
            @if(!empty($data->custom['body_family']))
                  font-family: '{{ $data->custom['body_family'] }}', '{{ $data->custom['body_category'] }}';
            font-style: {{ $data->custom['body_weight'] }};
            @if(strpos($data->custom['body_weight'], 'italic'))
  font-style: italic;
            @endif
        @else
  font-family: 'Helvetica';
        @endif




        }


        img.watermark-draft {
            width: 20%;
            position: absolute !important;
            bottom: 10%;
            left: 50%;
            opacity: 0.5;
            margin: auto;
            margin-left: -10%;
        }

        .page-break {
            page-break-after: always;
        }

        div[id^="page"] {
            position: relative;
            width: 760px !important;
            height: 760px !important;
            margin: 0;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            overflow: hidden;
        }

        div[id^="page"] * {
            position: absolute;
        }

        div.page_wide {
            width: 1520px !important;
            height: 760px !important;
        }

        div.page_wide.right {
            right: 0;
        }

        .title {
            font-weight: 700;
            font-size: 100px;
        }

        chapterNumber {
            font-size: 750px;
            font-weight: 700;
            color: white;
        }

        chapterTitle {
            color: white;
            font-size: 250px;
            font-weight: 700;
            left: 50px;
            bottom: 100px;
        }

        pageNumber {
            left: 50px;
            top: 58px;
            font-size: 32px;
            font-weight: 400;
            text-align: left;
            position: absolute;
        }

        div.page_wide.right pageNumber {
            left: auto;
            right: 50px;
        }

        .inverted pageNumber {
            color: white;
        }

        hr.roof {
            border-top: solid 2px black;
            border-bottom: none;
            top: 45px;
            right: 50px;
            left: 50px;
            position: absolute;
        }

        .inverted hr.roof {
            border-top: solid 2px white;
        }

        hr.basement {
            border: none;
            border-top: solid 7px black;
            bottom: 66px;
            right: 50px;
            left: 50px;
            position: absolute;
        }

        .inverted hr.basement {
            border-top: solid 7px white;
        }

        basementBrand {
            font-family: 'Helvetica';
            font-size: 16px;
            font-weight: 700;
            line-height: 46px;
            text-align: left;
            bottom: 30px;
            left: 50px;
            z-index: 3;
            color: black;
            position: absolute;
        }

        basementBrand:before {
            content: '{{$data->brand}} {{trans('themes.brand_book')}}';
        }

        pageInterior {
            top: 55px;
            left: 50px;
            bottom: 81px;
            right: 50px;
            display: flex;
            flex-direction: column;
        }

        pageInteriorHalf {
            top: 54px;
            left: 50px;
            bottom: 80px;
            right: 840px;
            display: flex;
            flex-direction: column;
        }

        pageInterior *, .pageInterior *,
        pageInteriorHalf *, .pageInteriorHalf *
        pageInteriorMaxi *, .pageInteriorMaxi *,
        pageInteriorMini *, .pageInteriorMini * {
            position: relative !important;
        }

        pageInteriorHalf.right, .pageInteriorHalf.right {
            left: 760px;
            right: 50px;
        }

        .pageInteriorMini, pageInteriorMini {
            top: 55px;
            left: 50px;
            bottom: 81px;
            width: 525px;
            display: flex;
            flex-direction: column;
        }

        .pageInteriorMini.right, pageInteriorMini.right {
            left: auto;
            right: 50px;
        }

        pageInteriorMaxi, .pageInteriorMaxi {
            top: 55px;
            left: 50px;
            bottom: 81px;
            right: 575px;
            display: flex;
            flex-direction: column;
        }

        .pageInteriorMaxi.right, pageInteriorMaxi.right {
            left: 575px;
            right: 50px;
        }

        .toBottom {
            flex-direction: column;
            display: flex;
            justify-content: flex-end;
        }

        .toMiddle {
            flex-direction: column;
            display: flex;
            justify-content: center;
        }

        .toCenter {
            flex-direction: row;
            display: flex;
            align-items: center;
        }

        .h100 {
            height: 100%;
        }

        .w100 {
            width: 100%;
        }

        pageTitle {
            font-size: 100px;
            font-weight: 700;
            color: black;
            display: block;
        }

        .relative, .relatives * {
            position: relative !important;
        }

        vtable {
            display: table;
            width: 100%;
            height: 100%;
        }

        valign {
            width: 100%;
            height: 100%;
            display: table-cell;
            vertical-align: middle;
        }

        .inverted basementBrand, basementBrand.inverted {
            color: white;
        }

        .primary_color {
            color: {{ $data->colors_list[0]->id }};
        }

        .primary_background {
            background-color: {{ $data->colors_list[0]->id }};
        }

        .secondary_color {
            color: {{ $data->colors_list[1]->id }};
        }

        .secondary_background {
            background-color: {{ $data->colors_list[1]->id }};
        }

        .tetriatry_color {
            color: {{ $data->colors_list[2]->id }};
        }

        .tetriatry_background {
            background-color: {{ $data->colors_list[2]->id }};
        }

        .vision-text{
            padding: 50px;
            height: 380px;
        }

        .vision-text div{
            color:black;
            font-weight:700;
            line-height:120%!important;
            font-size:25px;
        }

        .grey_color {
            color: #999;
        }

        .grey_background {
            background-color: #999;
        }

        .white_color {
            color: white;
        }

        .white_background {
            background-color: white;
        }

        .black_color {
            color: black;
        }

        .black_background {
            background-color: black;
        }

        * {
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
        }

    </style>
    <meta charset="utf-8">
</head>
<body>

@if(
    request()->is('my/pdf/*') ||
    request()->is('my/logo/*') ||
    request()->is('admin/brandbook-files*')
)
@section('prefrontCover')
    <div id="page0">
        &nbsp;
    </div>
@endsection
@endif

@section('frontCoverCustom')
    <div id="page{{ $page }}" style="
            background-image: url( {{
public_path(
    config('app.images_path') .
    $data->user_id . '/' .
    $data->id . '/' .
    $data->custom_logo
)
}} );
            background-size: cover;
            background-position: center;
            ">
    </div>
@endsection

@section('frontCover')
    <div id="page{{ $page }}" class="inverted" style="background: black">
        <hr class="basement">
        <pageInteriorHalf>
            <div style="width: 660px; height: 625px; padding: 150px; margin-top: -100px;">
                <img src="{{ $data->logo_b64 }}" width="100%" height="100%" style="object-fit: contain;">
            </div>
            <div style="width:630px;color:white;font-size:50px;font-weight:700;text-align:left;margin-top: 20px;height: 600px !important; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                {{ $data->brand }} {{ trans('themes.brand_book') }}
            </div>
        </pageInteriorHalf>
        @if($data->watermark)
            <img class="watermark-draft cover" src="{{$watermark}}">
        @endif
    </div>
@endsection

@section('bookIntro')
    @foreach ($themeHelper->pagesFor('bookIntro', $page) as $side => $page)
        <div class="page-break pbb1"></div>
        <div id="page{{ $page }}" class="inverted" style="background: black">
            <div class="page_wide {{ $side }}">
                <hr class="roof" style="width:1000px;left: auto;">
                @if($page != 2)
                    <pageNumber>{{ sprintf('%02d', $page) }}</pageNumber>
                @endif
                <hr class="basement">
                <basementBrand></basementBrand>

                <chapterNumber class="custom_title" style="left:110px;top:-212px;">
                    1
                </chapterNumber>

                <chapterTitle
                        class="custom_title"
                        style="font-size:{{ app()->getLocale() == 'ja' ? 80 : 123}}px;"
                        contenteditable="true" @blur="title_changed()" data-title-field="introduction_title">
                    {!! $data->introduction_title ?: trans('themes.introduction') !!}
                </chapterTitle>

                <pageInteriorMini class="right">
                    <div
                            class="custom_text white_color"
                            style="padding: 50px 0; margin-top: auto;"
                    >
                        <div class="text" data-field="introduction_text">
                            @if($data->introduction_text)
                                {!! $data->introduction_text !!}
                            @else
                                <p>
                                    {{trans('themes.welcome_to_the_officisal', ['brand' => $data->brand])}}
                                </p>
                                <br>
                                <br>
                                {{trans('themes.it_is_important_that', ['brand' => $data->brand])}}
                                <br>
                                <br>
                                {{trans('themes.note_that_by_using', ['brand' => $data->brand])}}
                            @endif
                        </div>
                    </div>
                </pageInteriorMini>
            </div>
            @if($data->watermark)
                <img class="watermark-draft" src="{{$watermark}}">
            @endif
        </div>
    @endforeach
@endsection

@php
    $page = $themeHelper->adjustPageNumberForMockups($page);
@endphp

@if($data->vision)
@section('bookVision')
    @foreach ($themeHelper->pagesFor('bookVision', $page) as $side => $page)
        <div class="page-break pbb{{ $page }}"></div>
        <div id="page{{ $page }}" style="background: white">
            <div class="page_wide {{ $side }}">
                <hr class="roof">
                <pageNumber>{{ sprintf('%02d', $page) }}</pageNumber>
                <hr class="basement">
                <basementBrand></basementBrand>

                <pageInteriorHalf class="toBottom right">
                    <div
                            class="custom_title"
                            style="font-size:100px;font-weight:700;padding-left: 50px;"
                            contenteditable="true" @blur="title_changed()" data-title-field="vision_title">
                        {!! $data->vision_title ?: trans('themes.vision') !!}
                    </div>

                    <div
                            class="text autosize vision-text"
                            data-field="vision"><div>
                            {!! $data->vision !!}
                        </div>
                    </div>
                </pageInteriorHalf>
            </div>
            @if($data->watermark)
                <img class="watermark-draft" src="{{$watermark}}">
            @endif
        </div>
    @endforeach
@endsection
@endif

@section('bookMission')
    @if($data->mission)
        {{-- Mission --}}
        @foreach ($themeHelper->pagesFor('bookMission', $page) as $side => $page)
            <div class="page-break pbb{{ $page }}"></div>
            <div id="page{{ $page }}" class="inverted" style="background: black">
                <div class="page_wide {{ $side }}">
                    <hr class="roof">
                    <pageNumber>{{ sprintf('%02d', $page) }}</pageNumber>
                    <hr class="basement">
                    <basementBrand></basementBrand>
                    <style>
                        .mission-text{
                            height: 300px;
                            padding-bottom: 50px;
                        }

                        .mission-text div{
                            color: white;
                            font-size: 25px;
                            font-weight: 700;
                            line-height: 120%;
                        }
                    </style>
                    <pageInteriorHalf class="toBottom">
                        <div
                                class="custom_title"
                                style="font-size:100px;color:white;font-weight:700;"
                                contenteditable="true" @blur="title_changed()" data-title-field="mission_title">
                            {!! $data->mission_title ?: trans('themes.mission') !!}
                        </div>
                        <div class="text autosize mission-text" data-field="mission"><div>
                                {!! $data->mission !!}
                            </div>
                        </div>
                    </pageInteriorHalf>
                </div>
                @if($data->watermark)
                    <img class="watermark-draft" src="{{$watermark}}">
                @endif
            </div>
        @endforeach
    @endif
@endsection

@section('coreValues')
    @if(count($data->core_values) || $data->core_text)
        <style>

            core_values, core_values * {
                position: relative !important;
            }

            core_value {
                margin-bottom: 30px;
                width: 740px;
                display: block;
            }

            core_value img {
                margin-right: 40px;
            }

            core_value_text * {
                position: relative;
            }

            core_value_texts {
                display: inline-block;
                width: 609px;
            }

            @php
            // calculate font size
            $title_length = 0;
            $text_length = 0;
            $core_value_title_font_size = 28;
            $core_value_description_font_size = 12;
            foreach($data->core_values as $core_value){
                $title_length += strlen($core_value['title']);
                $text_length += strlen($core_value['description']);
            }

            switch($text_length){
                case $text_length>400:
                    $core_value_title_font_size = 16;
                break;
                case $text_length>300:
                    $core_value_title_font_size = 18;
                break;
                case $text_length>200:
                    $core_value_title_font_size = 20;
                break;
            }

            switch($text_length){
                case $text_length>3000:
                    $core_value_title_font_size = 12;
                    $core_value_description_font_size = 8;
                break;
                case $text_length>2750:
                    $core_value_title_font_size = 13;
                    $core_value_description_font_size = 8.5;
                break;
                case $text_length>2500:
                    $core_value_title_font_size = 14;
                    $core_value_description_font_size = 9;
                break;
                case $text_length>2250:
                    $core_value_title_font_size = 15;
                    $core_value_description_font_size = 9.5;
                break;
                case $text_length>2000:
                    $core_value_title_font_size = 16;
                    $core_value_description_font_size = 10;
                break;
                case $text_length>1750:
                    $core_value_title_font_size = 17;
                    $core_value_description_font_size = 10.5;
                break;
                case $text_length>1500:
                    $core_value_title_font_size = 18;
                    $core_value_description_font_size = 11;
                break;
            }

            @endphp

            core_value_title {
                display: block;
                font-size: {{$core_value_title_font_size}}px;
                font-weight: 700;
                line-height: 120%;
            }

            core_value_description {
                font-size: {{$core_value_description_font_size}}px;
                font-weight: 400;
                line-height: 120%;
            }
        </style>
        @foreach ($themeHelper->pagesFor('coreValues', $page) as $side => $page)
            <div class="page-break pbb{{ $page }}"></div>
            <div id="page{{ $page }}">
                <div class="page_wide {{ $side }}">
                    <hr class="roof">
                    <pageNumber>{{ sprintf('%02d', $page) }}</pageNumber>
                    <hr class="basement">
                    <basementBrand></basementBrand>

                    <pageInteriorHalf class="toMiddle">
                        <core_values_title
                                class="custom_title title"
                                contenteditable="true" @blur="title_changed()" data-title-field="core_title">
                            {!! $data->core_title ?: __('Core Values') !!}
                        </core_values_title>

                        <div class="text core_values_text" data-field="core_text" style="width: 500px;">
                            @if(!empty($data->core_text))
                                {!!$data->core_text!!}
                            @else
                                <p>
                                    {{trans('themes.company_values_matter')}}
                                </p>
                            @endif
                        </div>

                    </pageInteriorHalf>

                    <pageInteriorHalf class="right" style="padding: 50px 0 50px 50px;">
                        <table width="100%" height="100%">
                            @foreach ($data->core_values as $core_value)
                                <tr>
                                    <td style="width:130px;">
                                        <img src="{{ $core_value['image'] }}"
                                             style="max-height:80px; max-height: 80px;">
                                    </td>
                                    <td>
                                        <core_value_title>
                                            {{ $core_value['title'] }}
                                        </core_value_title>
                                        <core_value_description class='text'>
                                            {{ $core_value['description'] }}
                                        </core_value_description>
                                    <td>
                                </tr>
                            @endforeach

                        </table>
                    </pageInteriorHalf>


                </div>
                @if($data->watermark)
                    <img class="watermark-draft" src="{{$watermark}}">
                @endif
            </div>
        @endforeach
    @endif
@endsection

@if(!empty($data->voices))
@section('voices')
    <style>
        .archetype-image-wrap *{
            position: relative !important;
        }

        @if(isset($data->colors_list[1]))
            .archetype-image-wrap path.secondary_color {
            fill: {{$data->colors_list[1]->id}};
        }
        @endif

            .archetype-image-wrap path.fill_white{
            fill:  black;
        }

        .archetype-image-wrap path.fill_black{
            fill:  white;
        }

        @if(isset($data->colors_list[0]))
            .archetype-image-wrap path.main_color {
            fill: {{$data->colors_list[0]->id}};
        }
        @endif

        .single_voice_container{
            height: 60%;
        }
        .single_voice_container svg{
            height: 100%;
            width: 50%;
        }

        .voice_title{
            font-size: 38px;
            font-weight: 700;
            line-height: 57px;
        }

        .double_voice_container{
            height: 50%;
        }

        .double_voice_container svg{
            height: 100%;
            width: 40%;
            float: left;
        }
        .double_voice_container.right svg{
            float: right;
        }

        .double_voice_container p{
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .double_voice_container.left svg{
            margin-right: 50px;
        }
        .and_label{
            font-size: 62px;
            font-weight: 700;
            letter-spacing: 0em;
        }
    </style>

    @foreach ($themeHelper->pagesFor('bookFont', $page) as $side => $page)
        <div class="page-break pbb{{ $page }}"></div>

        <div id="page{{ $page }}" class="inverted white_color">
            <div class="page_wide {{ $side }} black_background">
                <hr class="roof">
                <hr class="basement">
                <pageNumber>{{ sprintf('%02d', $page) }}</pageNumber>
                <basementBrand></basementBrand>
                @if(count($data->voices) === 1)
                    <pageInteriorHalf class="toBottom" style="padding-bottom: 50px;">
                        <h1 class="title">
                            {{trans('themes.Brand_Archetype')}}
                        </h1>
                        <div class="voices-text">{{trans('themes.archetype_text')}}</div>
                    </pageInteriorHalf>
                    <pageInteriorHalf class="right archetype-image-wrap">
                        <div class="single_voice_container">
                            {!! \App\BrandBookCreator\BrandBookHelper::getSVG_src($data->voices[0]) !!}
                        </div>
                        <h3 class="voice_title">
                            {{$data->voices[0]}}
                        </h3>
                        {!! \App\BrandBookCreator\BrandBookHelper::ARCHETYPES[$data->voices[0]]['description']!!}

                        <br>
                        <br>
                        <strong>
                            {{\App\BrandBookCreator\BrandBookHelper::ARCHETYPES[$data->voices[0]]['short_description']}}
                        </strong>

                    </pageInteriorHalf>
                @else
                    <pageInteriorMini class="toBottom" style="padding-bottom: 50px;">
                        <h1 class="title">
                            {{trans('themes.Brand_Archetype')}}
                        </h1>
                        <div class="voices-text">{{trans('themes.archetype_text')}}</div>
                    </pageInteriorMini>
                    <pageInteriorMaxi class="right white_color archetype-image-wrap" style="padding: 50px 0 50px 50px;">
                        <div class="double_voice_container left">
                            {!! \App\BrandBookCreator\BrandBookHelper::getSVG_src($data->voices[0]) !!}
                            <p style="padding-left: 50px;">
                            <h3 class="voice_title">
                                {{$data->voices[0]}}
                            </h3>
                            {!! \App\BrandBookCreator\BrandBookHelper::ARCHETYPES[$data->voices[0]]['description']!!}
                            <br>
                            <br>
                            <strong>
                                {{\App\BrandBookCreator\BrandBookHelper::ARCHETYPES[$data->voices[0]]['short_description']}}
                            </strong>
                            </p>
                        </div>

                        <div class="double_voice_container right">
                            {!! \App\BrandBookCreator\BrandBookHelper::getSVG_src($data->voices[1]) !!}
                            <p>
                            <h3 class="voice_title" style="line-height: 42px;">
                                <span class="and_label">&</span>
                                <br>
                                {{$data->voices[1]}}
                            </h3>
                            {!! \App\BrandBookCreator\BrandBookHelper::ARCHETYPES[$data->voices[1]]['description']!!}
                            <br>
                            <br>
                            <strong>
                                {{\App\BrandBookCreator\BrandBookHelper::ARCHETYPES[$data->voices[1]]['short_description']}}
                            </strong>
                            </p>

                        </div>

                    </pageInteriorMaxi>
                @endif
            </div>
            @if($data->watermark)
                <img class="watermark-draft" src="{{$watermark}}">
            @endif
        </div>
    @endforeach

@endsection
@endif

@section('bookLogo')
    <style>
        ml_chapter_title {
            left: 340px;
            font-size: 250px;
            color: white;
            top: 425px;
            font-weight: 700;
            z-index: 10;
        }

        ml_side_bar {
            top: 0;
            left: 0;
            bottom: 0;
            right: 573px;
        }

    </style>
    @foreach ($themeHelper->pagesFor('bookLogo', $page) as $side => $page)
        <div class="page-break pbb{{ $page }}"></div>
        <div
                id="page{{ $page }}"
                class="{{ $side == 'left' ? 'inverted primary_background' : "" }}">
            <div class="page_wide {{ $side }}">
                <hr class="roof">
                <pageNumber>{{ sprintf('%02d', $page) }}</pageNumber>
                @if($page%2)
                    <hr class="basement">
                @endif
                <basementBrand></basementBrand>
                <chapterNumber style="left:-70px;top:-40px;" class="custom_title">2</chapterNumber>
                <ml_chapter_title
                        contenteditable="true" @blur="title_changed()" data-title-field="logo_title" class="custom_title">
                    {{trans('themes.logo')}}
                </ml_chapter_title>
                @if($side ==  'right')
                    <ml_side_bar class="primary_background inverted">
                        <hr class="basement" style="right:0;left:850px;">
                        <hr class="roof" style="right:0;">
                    </ml_side_bar>
                @endif
                <pageInteriorMini class="right toMiddle" style="padding-bottom: 100px;">
                    <img src="{{ $white_bg_logo }}"
                         style="max-width:300px; max-height: 250px;margin-left: auto;margin-right: auto;">
                    <span style="text-align: center;margin-top: 20px;">{{ $data->logo_title }}</span>
                </pageInteriorMini>
                <pageInteriorMini class="right toBottom">
                    <div
                            style="padding:440px 0 50px 50px;"
                            data-field="logo_text" class="text ml_text" data-field="logo_text">
                        @if(!empty($data->logo_text))
                            {!!$data->logo_text!!}
                        @else
                            {{trans('themes.we_are_proud_logo')}}
                        @endif
                    </div>
                </pageInteriorMini>
            </div>
            @if($data->watermark)
                <img class="watermark-draft" src="{{$watermark}}">
            @endif
        </div>
    @endforeach

    @if(count($data->approved) || count($data->logo_versions) > 1)
        <div class="page-break pbb{{ $page++ }}"></div>
        <div id="page{{ $page }}">
            <div class="page_wide">
                <hr class="roof">
                <pageNumber>{{ sprintf('%02d', $page) }}</pageNumber>
                <hr class="basement">
                <basementBrand></basementBrand>
                <pageInteriorHalf class="toMiddle">
                    <pageTitle
                            class="primary_color custom_title title"
                            contenteditable="true" @blur="title_changed()" data-title-field="versions_title">
                        {!!$data->versions_title ?: trans('themes.logo_versions') !!}
                    </pageTitle>
                    <div style="padding:30px 0;width:550px;" class="text" data-field="versions_text">
                        @php
                            $color1 = isset($data->colors_list[0]) ? $data->colors_list[0]->color->name->value : '';
                            $color2 = isset($data->colors_list[1]) ? $data->colors_list[1]->color->name->value : '';
                        @endphp
                        {!! $data->versions_text ?: trans('themes.logo_colors', ['brand' => $data->brand, 'color1' => $color1, 'color2' => $color2]) !!}
                    </div>
                </pageInteriorHalf>
                <hr class="basement">
            </div>
            @if($data->watermark)
                <img class="watermark-draft" src="{{$watermark}}">
            @endif
        </div>


        {{-- Logo Variation Pages --}}
        <style>
            .logo_variation_container {
                flex-wrap: wrap;
                border-left: solid 1px black;
            }

            logo_variation {
                position: relative;
                width: 354px;
                height: 313px;
                border-bottom: solid 1px black;
                border-right: solid 1px black;
                display: inline-block;
            }

            logo_variation_interior {
                height: 313px;
                width: 392px;
                display: table-cell;
                vertical-align: middle;
                text-align: center;
            }

            logo_title {
                text-align: center;
                padding: 15px;
                display: block;
                position: absolute !important;
                bottom: 0;
                width: 353px;
            }

            .logo_title.negative {
                color: white !important;
            }
        </style>
        @foreach ($themeHelper->orderLogoVariations($data->approved, $data->logo_versions) as $chunk_index => $chunk)
            @php
                $page++;
                $side = $page % 2 ? 'right' : 'left';
            @endphp
            <div class="page-break pbb{{ $page }}"></div>
            <div id="page{{ $page }}">
                <div class="page_wide {{ $side }}" style="background: white">
                    <hr class="roof">
                    <hr class="basement">
                    <basementBrand></basementBrand>


                    <pageInteriorHalf class="{{ $side }} logo_variation_container">
                        @foreach ($chunk as $index => $logo)
                            <logo_variation
                                    style="background: {{ isset($logo->background) ? $logo->background : "transparent"  }}">
                                <logo_variation_interior>
                                    <img src="{{ $logo->logo_b64 }}" style="max-width: 50%; max-height: 50%;">
                                </logo_variation_interior>
                                <logo_title
                                        class="{{ !isset($logo->background) || $logo->background != 'transparent' ? 'white_color' : 'primary_color' }}">
                                    {{ $logo->title }}
                                </logo_title>
                            </logo_variation>
                        @endforeach
                    </pageInteriorHalf>

                </div>
                @if($data->watermark)
                    <img class="watermark-draft" src="{{$watermark}}">
                @endif
            </div>

        @endforeach

        {{-- Adding blanc page in the end if page number not even --}}
        @if(!($page % 2))
            @php
                $page++;
            @endphp
            <div class="page-break pbb{{ $page }}"></div>
            <div id="page{{ $page }}">
                <div class="page_wide right" style="background: white">
                    <hr class="roof">
                    <hr class="basement">
                    <pageNumber>{{ sprintf('%02d', $page) }}</pageNumber>
                    <basementBrand></basementBrand>
                </div>
                @if($data->watermark)
                    <img class="watermark-draft" src="{{$watermark}}">
                @endif
            </div>
        @endif

    @endif
@endsection

@php
    $page = $themeHelper->adjustPageNumberForMockups($page);
@endphp

@if($data->icon)
@section('bookIcon')
    <style>
        icons {

        }

        icon {
            display: inline-block;
            align-items: center;
            height: 125px;
            text-align: center;
            width: 170px;
        }

        icon_title {
            padding: 10px 10% 0 10%;
            font-size: 13px;
            line-height: 16px;
            display: flex;
        }

        icon_image_container {
            background-size: 50%;
            background-repeat: no-repeat;
            width: 55px;
            height: 55px;
            display: inline-block;
            background-position: center center;
        }

        .bigIcon {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        ic_pageTitle {
            padding: 30px 0 20px 0;
            display: block;
            font-size: 100px;
            font-weight: 700;
        }

        icon_interior {
            display: table-cell;
            width: 1055px;
            height: 700px;
            vertical-align: middle;
            text-align: center;
        }

        .icon_container, .icon_container * {
            position: relative !important;
        }
    </style>
    @foreach ($themeHelper->pagesFor('bookIcon', $page) as $side => $page)
        <div class="page-break pbb{{ $page }}"></div>
        <div id="page{{ $page }}">
            <div class="page_wide {{ $side }}" style="background: white">
                <hr class="roof">
                <hr class="basement">
                <pageNumber>{{ sprintf('%02d', $page) }}</pageNumber>
                <basementBrand></basementBrand>
                <pageInteriorMini>
                    <ic_pageTitle
                            class="primary_color custom_title title"
                            contenteditable="true" @blur="title_changed()" data-title-field="icon_title">
                        {!! $data->icon_title ?: trans('themes.our_icon_and_favicon') !!}
                    </ic_pageTitle>
                    <div class="text" data-field="icon_text">
                        @php
                            $color = isset($data->colors_list[0]) ? $data->colors_list[0]->color->name->value : '';
                        @endphp
                        {!! $data->icon_text ?: trans('themes.icon_text', ['brand'=>$data->brand, 'color'=> $color]) !!}
                    </div>
                    <br>
                    <icons>
                        @foreach ($data->approved_icon as $icon)
                            <icon>
                                <icon_image_container
                                        style="
                                                background-image: url('{{ $icon['icon_b64'] }}');
                                                background-color: {{ $icon['background'] }};
                                                border-radius: {{
                                            array_key_exists('border_radius', $icon) ?
                                            $icon['border_radius'] :
                                            "50%"
                                        }};
                                                ">
                                </icon_image_container>
                                <icon_title>
                                    {{ $icon['title'] }}
                                </icon_title>
                            </icon>
                        @endforeach
                    </icons>
                </pageInteriorMini>

                <pageInteriorMaxi class="bigIcon right toMiddle">

                    <div class="toMiddle icon_container">
                        <img src="{{ $data->icon_b64 }}" width="250" style="
                            margin-bottom:30px;
                            margin-left: auto;
                            margin-right: auto;
                        ">
                        <p style="text-align: center;">
                            @isset($data->icon_caption)
                                {{ $data->icon_caption }}
                            @else
                                {{trans('themes.the_brand_book_icon', ['brand' => $data->brand])}}
                            @endisset
                        </p>
                    </div>

                </pageInteriorMaxi>
            </div>
            @if($data->watermark)
                <img class="watermark-draft" src="{{$watermark}}">
            @endif
        </div>
    @endforeach
@endsection
@endif

@section('bookGuidelines')
    <style>
        gl_color_fill {
            top: 0;
            left: 0;
            right: 573px;
            bottom: 0;
        }

        gl_chapter {
            font-size: 831px;
            color: white;
            font-weight: 700;
            top: -370px;
            left: -120px;
        }

        gl_chapter_title {
            color: white;
            font-size: {{ app()->getLocale() == 'ja' ? 150 : 170 }}px;
            font-weight: 700;
            bottom: 60px;
            left: 50px;
            z-index: 10;
        }

        gl_texts {
            left: 1165px;
            right: 50px;
            bottom: 81px;
            top: 130px;
            display: flex;
            flex-direction: column;
        }

        gl_texts * {
            position: relative !important;
        }

        gl_proportions_title {
            font-size: 70px;
            font-weight: 700;
            margin-bottom: 30px;
        }

        gl_proportions_text {
            font-size: 16px;
            font-weight: 400;
            line-height: 25px;
        }

        .logo-image {
            width: 100%;
            height: 100px;
            background-size: contain;
            background-position: center center;
            background-repeat: no-repeat;
        }

    </style>
    @foreach ($themeHelper->pagesFor('bookGuidelines', $page) as $side => $page)
        <div class="page-break pbb{{ $page }}"></div>
        <div id="page{{ $page }}" class="{{ $page % 2 ? '' : 'inverted secondary_background' }}">
            <div class="page_wide {{ $side }}">
                <hr class="roof" style="width:1000px;left:auto;">
                @if($page%2)
                    <hr class="basement">
                @endif
                <pageNumber>{{ sprintf('%02d', $page) }}</pageNumber>
                <basementBrand class="inverted" style="z-index: 10"></basementBrand>
                <pageInteriorMaxi>
                    <gl_chapter class="custom_title">3</gl_chapter>
                </pageInteriorMaxi>
                <gl_chapter_title class="custom_title">{{trans('themes.guidelines')}}</gl_chapter_title>

                @if($page % 2)
                    <ml_side_bar class="secondary_background inverted">
                        <hr class="basement" style="right:0;left:850px;">
                        <hr class="roof" style="right:0;">
            </div>
            @endif
            <pageInteriorMini class="right">
                <div style="padding: 50px 0 0 50px;">
                    <pageTitle
                            class="custom_title title"
                            style="font-size: 70px; padding-bottom: 30px;"
                            contenteditable="true" @blur="title_changed()" data-title-field="proportions_title">
                        @isset($data->proportions_title)
                            {!! $data->proportions_title !!}
                        @else
                            {{trans('themes.logo_and_icon_proportions')}}
                        @endisset
                    </pageTitle>
                    <div
                            class="text"
                            data-field="proportions_text"
                            style="max-height: 120px">
                        @if(!empty($data->proportions_text))
                            {!! $data->proportions_text !!}
                        @else
                            {{trans('themes.the_logo_prop', ['brand' => $data->brand, 'text_small' => $themeHelper->logo_proportions['proportions_text_small']])}}
                            @if($themeHelper->icon_proportions)
                                {{trans('themes.the_icon_prop', ['text_small' => $themeHelper->icon_proportions['proportions_text_small']])}}
                            @endif
                        @endif
                    </div>
                    <style>
                        proportions_container {
                            display: flex;
                            margin-left: 50px;
                            flex-direction: column;
                            align-items: flex-start;
                            justify-content: space-around;
                            min-height: 300px;
                            display: flex;
                            flex-direction: row;
                            justify-content: space-between;
                        }

                        proportions_container.flat {
                            flex-direction: column;
                        }


                        proportions * {
                            position: relative !important;
                        }

                        proportions {
                            position: relative !important;
                            display: inline-block;
                            margin-top: 60px;
                            margin-right: 60px;
                            max-height: 250px;
                        }

                        proportions img.proportion_image {
                            border: solid 1px black;
                            min-height: 80px;
                            min-width: 80px;
                        }

                        proportions img.proportion_image.tall {
                            max-width: 80px;
                            max-height: 250px;
                        }

                        proportions img.proportion_image.flat {
                            max-height: 80px;
                            height: 80px;
                            max-width: 300px;
                        }

                        proportions topArrow {
                            position: absolute !important;
                            border-left: solid 1px black;
                            border-right: solid 1px black;
                            border-top: 0;
                            height: 50px;
                            background: url({{ url('/images/theme/black_pixel.svg') }}) repeat-x 0 20px,
                            url({{ url('/images/theme/arrow_left.svg') }}) no-repeat 0 17px,
                            url({{ url('/images/theme/arrow_right.svg') }}) no-repeat 100% 17px;
                            top: -50px;
                            width: 100%;
                            text-align: center;
                        }

                        proportions leftArrow {
                            position: absolute !important;
                            border-top: solid 1px black;
                            border-bottom: solid 1px black;
                            width: 50px;
                            background: url({{ url('/images/theme/black_pixel.svg') }}) repeat-y 20px 0,
                            url({{ url('/images/theme/arrow_top.svg') }}) no-repeat 17px 0,
                            url({{ url('/images/theme/arrow_bottom.svg') }}) no-repeat 17px 100%;
                            left: -50px;
                            height: 100%;
                            display: flex;
                            align-items: center;
                        }
                    </style>

                    <proportions_container class="
                            {{ $themeHelper->proportionImages()['logo']['orientation'] }}
                            ">

                        @foreach ($themeHelper->proportionImages() as $proportionImage)
                            <proportions>
                                <topArrow>
                                    {!! $proportionImage['proportions_x'] !!}
                                </topArrow>
                                <leftArrow>
                                    {!! $proportionImage['proportions_y'] !!}
                                </leftArrow>
                                <img
                                        class="proportion_image {{ $proportionImage['orientation'] }}"
                                        src="{{ $proportionImage['image'] }}"/>
                            </proportions>

                        @endforeach
                    </proportions_container>


                </div>
            </pageInteriorMini>
            @if($data->watermark)
                <img class="watermark-draft" src="{{$watermark}}">
            @endif
        </div>
        </div>
    @endforeach
@endsection

@section('clearSpace')
    <style>
        cs_title {
            color: white;
            font-weight: 700;
            font-size: 100px;
        }

        .cs_text {
            color: white;
            font-size: 16px;
            line-height: 25px;
        }

        .cs_texts {
            justify-content: flex-end;
            padding-bottom: 50px;
        }

        clear_space_images {
            position: absolute;
            top: 0;
            left: 500px;
            right: 0;
            bottom: 0;
            display: flex;
            flex-direction: row;
            justify-content: space-around;

        }

        clear_space_images .clear_space_image_container {
            position: relative;
        }

        cs_container {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-evenly;
            height: 100%;
        }
    </style>
    @foreach ($themeHelper->pagesFor('clearSpace', $page) as $side => $page)
        <div class="page-break pbb{{ $page }}"></div>
        <div id="page{{ $page }}" class="inverted">
            <div class="page_wide {{ $side }}" style="background: black">
                <hr class="roof">
                <hr class="basement">
                <pageNumber>{{ sprintf('%02d', $page) }}</pageNumber>
                <basementBrand class="inverted" style="z-index: 10"></basementBrand>

                <pageInteriorMini class="cs_texts">
                    <cs_title
                            class="custom_title title"
                            contenteditable="true" data-title-field="space_title">
                        {{ $data->space_title ?: trans('themes.clear_space') }}
                    </cs_title>
                    <div class="text cs_text" data-field="space_text">
                        @if(!empty($data->space_text))
                            {!!$data->space_text!!}
                        @else
                            {!! trans('themes.clear_space_text', ['brand' => $data->brand]) !!}
                        @endif
                    </div>
                </pageInteriorMini>

                <pageInteriorMaxi class="right">
                    <cs_container>
                        <style>
                            cs_ruler_top, cs_ruler_left {
                                position: absolute !important;
                            }

                            cs_left, cs_top, cs_bottom, cs_right {
                                border: solid 1px{{ $themeHelper->secondary_color }};
                                position: absolute !important;
                                background: {{ $themeHelper->colorRGBA(1, 0.3) }}




                            }

                            cs_left {
                                top: 0;
                                bottom: 0;
                                left: 0;
                            }

                            cs_right {
                                top: 0;
                                bottom: 0;
                                right: 0;
                            }

                            cs_top {
                                top: 0;
                                left: 0;
                                right: 0;
                            }

                            cs_bottom {
                                bottom: 0;
                                left: 0;
                                right: 0;
                            }

                            cs_item {
                                display: inline-block;
                                position: relative !important;
                            }

                            .cs_ruler * {
                                stroke: {{ $themeHelper->secondary_color }};
                                fill: {{ $themeHelper->secondary_color }};
                            }

                            cs_ruler_top span, cs_ruler_left span {
                                font-size: 14px;
                                position: absolute;
                            }
                        </style>
                        @foreach ($themeHelper->clearSpaceImages() as $csImage)
                            <cs_item style="
                                    margin: 0 100px;
                                    padding: {{ $csImage['space']['free_space_y_h'] }}px {{ $csImage['space']['free_space_x_w'] }}px;
                                    ">
                                <cs_ruler_top style="
                                        top: -{{ $csImage['space']['free_space_y_h'] }}px;
                                        left: 0;
                                        ">

                                    <svg class="cs_ruler"
                                         width="{{ $csImage['space']['free_space_x_w'] }}"
                                         height="{{ $csImage['space']['free_space_y_h'] }}"
                                         viewBox="0 0 53 35"
                                         fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0.916992 34L0.918449 0.89"/>
                                        <path d="M6.00098 9.88867L47.001 9.88868"/>
                                        <path d="M-3.65539e-07 10L9 12.5981L9 7.40192L-3.65539e-07 10Z"/>
                                        <path d="M52 10L43 7.40192L43 12.5981L52 10Z"/>
                                        <path d="M52.7344 34L52.7358 0.89"/>
                                    </svg>
                                    <cs_ruler_text
                                            style="
                                                    width:{{ $csImage['space']['free_space_x_w'] }}px;
                                                    height:{{ $csImage['space']['free_space_y_h'] }}px;
                                                    display: flex;
                                                    top: -20px;
                                                    justify-content: center;
                                                    align-items: flex-start;

                                                    "
                                            class="secondary_color">
                                        {!! $csImage['space']['free_space_x'] !!}
                                    </cs_ruler_text>

                                </cs_ruler_top>
                                <cs_ruler_left style="
                                        top: 0;
                                        left: -{{ $csImage['space']['free_space_y_h'] }}px;
                                        ">
                                    <svg
                                            class="cs_ruler"
                                            width="{{ $csImage['space']['free_space_x_w'] }}"
                                            height="{{ $csImage['space']['free_space_y_h'] }}"
                                            viewBox="0 0 34 52" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M33.6504 51.418L0.540391 51.4165"/>
                                        <path d="M9.88965 46L9.88965 6"/>
                                        <path d="M10 52L12.5981 43L7.40193 43L10 52Z"/>
                                        <path d="M10 1L7.40192 10L12.5981 10L10 1Z"/>
                                        <path d="M34 0.419922L0.890001 0.418461"/>
                                    </svg>
                                    <cs_ruler_text
                                            style="
                                                    width:{{ $csImage['space']['free_space_x_w'] }}px;
                                                    height:{{ $csImage['space']['free_space_y_h'] }}px;
                                                    display: flex;
                                                    top: 0;
                                                    left: -{{ $csImage['space']['free_space_x_w'] }}px;
                                                    justify-content: flex-end;
                                                    align-items: center;
                                                    "
                                            class="secondary_color">
                                        {!! $csImage['space']['free_space_y'] !!}
                                    </cs_ruler_text>
                                </cs_ruler_left>

                                <cs_left style="width: {{ $csImage['space']['free_space_x_w'] }}px"></cs_left>
                                <cs_right style="width: {{ $csImage['space']['free_space_x_w'] }}px"></cs_right>
                                <cs_top style="height: {{ $csImage['space']['free_space_y_h'] }}px"></cs_top>
                                <cs_bottom style="height: {{ $csImage['space']['free_space_y_h'] }}px"></cs_bottom>
                                <img
                                        style="position: relative !important;"
                                        src="{{ $csImage['image'] }}"
                                        height="{{ $csImage['space']['image_h'] }}"
                                        width="{{ $csImage['space']['image_w'] }}"
                                />
                            </cs_item>
                        @endforeach
                        <cs_container>
                </pageInteriorMaxi>
            </div>
            @if($data->watermark)
                <img class="watermark-draft" src="{{$watermark}}">
            @endif
        </div>
    @endforeach
@endsection

@section('minimumSize')
    @if($data->size)
        {{-- Minimum Size (MS) --}}
        <style>
            ms_title {
                font-size: 100px;
                font-weight: 700;
            }

            ms_image {
                background-position: center;
                background-repeat: no-repeat;
                width: 100%;
                height: 100%;
                background-size: contain;
                display: inline-block;
                border-style: none dashed;
                border-width: 0 1px;
            }

            ms_item {
                display: inline-block;
            }

            arrow_h {
                width: 100%;
                height: 30px;
                display: block;
                border-width: 0 1px;
                border-style: solid;
                background: url({{ url('/images/theme/black_pixel.svg') }}) repeat-x 0 20px,
                url({{ url('/images/theme/arrow_left.svg') }}) no-repeat 0 17px,
                url({{ url('/images/theme/arrow_right.svg') }}) no-repeat 100% 17px;
            }

            arrow_h arrow_line {
                border-bottom: solid 1px black;
                width: 100%;
                display: block;
                padding-bottom: 10px;
            }

            ms_container {
                display: flex;
                flex-direction: row;
                height: 100%;
                align-items: center;
                justify-content: center;
                text-align: center;
            }

            ms_block {
                position: relative !important;
                display: flex;
                flex-direction: column;
                align-items: center;
                height: 300px;
                width: 300px;
                text-align: center;
                justify-content: center;
                margin: 0 50px;
            }

            ms_caption, ms_sizes {
                margin-top: 50px;
                font-size: 16px;
                display: block;
            }

            ms_caption {
                position: absolute !important;
                bottom: -50px;
            }

            .ms_images * {
                position: relative !important;
            }
        </style>
        @foreach ($themeHelper->pagesFor('minimumSize', $page) as $side => $page)
            <div class="page-break pbb{{ $page }}"></div>
            <div id="page{{ $page }}">
                <div class="page_wide {{ $side }}" style="background: white">
                    <hr class="roof">
                    <hr class="basement">
                    <pageNumber>{{ sprintf('%02d', $page) }}</pageNumber>
                    <basementBrand></basementBrand>

                    <pageInteriorMini class="toMiddle">
                        <ms_title
                                class="secondary_color custom_title title"
                                contenteditable="true" @blur="title_changed()" data-title-field="size_title">
                            {!! $data->size_title ?: trans('themes.minimum_size') !!}
                        </ms_title>
                        <div class="text ms_text" data-field="size_text">
                            @if(!empty($data->size_text))
                                {!!$data->size_text!!}
                            @else
                                <p>{{trans('themes.establishing')}}</p>
                            @endif
                        </div>
                    </pageInteriorMini>

                    <pageInteriorMaxi class="right toMiddle ms_images" style="padding-bottom:150px;">
                        <div class="toCenter">
                            @foreach (['icon', 'logo'] as $type)
                                @if($sizes = $themeHelper->minimumSize($type))
                                    <ms_block>
                                        <ms_item style="width:{{ $sizes['px'] }}px; height:{{ $sizes['px'] }}px">
                                            <ms_image style="
                                                    background-image: url({{ $sizes['image'] == 'white_bg_logo' ? $white_bg_logo : $sizes['image'] }});
                                                    position: relative !important;
                                                    "></ms_image>
                                            <arrow_h></arrow_h>
                                        </ms_item>
                                        <ms_caption style="position: absolute !important">
                                            {{ $sizes['px'] }}px/{{ $sizes['mm'] }}mm
                                            <br>
                                            <br>
                                            {!! __('The logo should never be smaller than :size_px px in digital and :size_mm mm in print.', [
                                                'size_px' => $sizes['px'],
                                                'size_mm' => $sizes['mm'],
                                            ]) !!}
                                        </ms_caption>
                                    </ms_block>
                                @endif
                            @endforeach
                        </div>
                    </pageInteriorMaxi>
                </div>
                @if($data->watermark)
                    <img class="watermark-draft" src="{{$watermark}}">
                @endif
            </div>
        @endforeach
    @endif
@endsection

@php
    $page = $themeHelper->adjustPageNumberForMockups($page);
@endphp


@section('logoMisuse')
    @if($data->missuses)
        {{-- Logo Misuse (LM) --}}
        <style>
            lm_texts {
                top: 271px;
                left: 1000px;
                right: 50px;
                bottom: 81px;
                display: flex;
                flex-direction: column;
            }

            lm_texts * {
                position: relative !important;
            }

            lm_title {
                font-size: 100px;
                font-weight: 700;
            }

            lm_container {
                top: 150px;
                left: 50px;
                bottom: 81px;
                width: 920px;
                display: flex;
                flex-wrap: wrap;
            }

            lm_container * {
                position: relative !important;
            }

            lm_item {
                width: 230px;
                height: 230px;
                display: flex;
                flex-direction: column;
            }

            lm_image_title {
                font-size: 12px;
                text-align: center;
            }

            lm_image_container {
                padding: 20px;
            }

            lm_image {
                width: 200px;
                height: 180px;
                display: block;
                background-size: contain;
                background-repeat: no-repeat;
                background-position: center;
            }

            lm_line {
                position: absolute;
                width: 250px;
                height: 1px;
                z-index: 10;
                top: 120px;
                border-top: 2px solid #FF0000;
                transform: rotate(144.65deg);
            }


        </style>
        @foreach ($themeHelper->pagesFor('logoMisuse', $page) as $side => $page)
            <div class="page-break pbb{{ $page }}"></div>
            <div id="page{{ $page }}">
                <div class="page_wide {{ $side }}" style="background: white">
                    <hr class="roof">
                    <hr class="basement">
                    <pageNumber>{{ sprintf('%02d', $page) }}</pageNumber>
                    <basementBrand></basementBrand>

                    <lm_texts>
                        <lm_title
                                class="secondary_color custom_title title"
                                contenteditable="true" @blur="title_changed()" data-title-field="misuse_title">
                            {!! $data->misuse_title ?: trans('themes.logo_misuse') !!}
                        </lm_title>
                        <div class="text lm_text" data-field="misuse_text">
                            @if(!empty($data->misuse_text))
                                {!!$data->misuse_text!!}
                            @else
                                <p>{!! trans('themes.it_is_important_that_appearance') !!}</p>
                            @endif
                        </div>
                    </lm_texts>
                    <lm_container>
                        @foreach($data->missuses as $missuse)
                            <lm_item>
                                <lm_line></lm_line>
                                <lm_image_container>
                                    <lm_image style="
                                    @foreach($missuse->style as $key=>$value)
                                    {{$themeHelper::from_camel_case($key)}}:
                                    @if($value=='rotate(45deg)')
                                            rotate(20deg)
                                    @else
                                    {{$value}}
                                    @endif;
                                    @endforeach
                                            background-image: url({{$missuse->logo_b64}});
                                            ">
                                    </lm_image>
                                </lm_image_container>
                                <lm_image_title>{{$missuse->title}}</lm_image_title>
                            </lm_item>
                        @endforeach
                    </lm_container>
                </div>
                @if($data->watermark)
                    <img class="watermark-draft" src="{{$watermark}}">
                @endif
            </div>
        @endforeach
    @endif
@endsection

@if(count($data->icon_family))
@section('featureIcons')
    <style>
        fi_texts * {
            position: relative !important;
        }

        fi_title {
            font-size: 100px;
            font-weight: 700;
        }

        .fi_container {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
        }

        .fi_container * {
            position: relative !important;
        }

        fi_item {
            display: block;
            width: 100px;
            height: 100px;
            padding: 50px;
        }

        fi_image {
            display: block;
            background-repeat: no-repeat;
            background-position: center;
            background-size: contain;
            width: 100%;
            height: 100%;
        }

        fi_image_title {
            text-align: center;
            display: block;
            margin-top: 15px;
        }

        .fi_container.grid_12 fi_item {
            width: 220px;
            height: 180px;
        }

        .fi_container.grid_6 fi_item {
            width: 250px;
            height: 200px;
        }

        .fi_container.grid_2 * {
            width: 350px;
            height: 350px;
        }

    </style>
    @foreach ($themeHelper->pagesFor('featureIcons', $page) as $side => $page)
        <div class="page-break pbb{{ $page }}"></div>
        <div id="page{{ $page }}">
            <div class="page_wide {{ $side }}">
                <hr class="roof">
                <hr class="basement">
                <pageNumber>{{ sprintf('%02d', $page) }}</pageNumber>
                <basementBrand></basementBrand>

                <pageInteriorMini style='justify-content: center;'>
                    <pageTitle class="secondary_color custom_title">
                        {{trans('themes.feature_icons')}}
                    </pageTitle>
                    <div class="custom_text">
                        {!!trans('themes.icons_are_the_visual')!!}
                    </div>
                </pageInteriorMini>
                <pageInteriorMaxi class="right fi_container {{ $themeHelper->featureIconGridClass() }}">
                    @foreach($data->icon_family as $icon)
                        @isset($icon['b64'])
                            <fi_item>
                                <fi_image_container>
                                    <fi_image style="background-image:url({{ $icon['b64'] }})"></fi_image>
                                </fi_image_container>
                                <fi_image_title>
                                    {{ __(Arr::get($icon, 'title')) }}
                                </fi_image_title>
                            </fi_item>
                        @endisset
                    @endforeach
                </pageInteriorMaxi>
            </div>
            @if($data->watermark)
                <img class="watermark-draft" src="{{$watermark}}">
            @endif
        </div>
    @endforeach
@endsection
@endif

@section('colorPalette')
    {{-- Color Palette (CP) --}}
    <style>
        cp_chapter {
            font-size: 831px;
            font-weight: 700;
            color: white;
            top: -386px;
            left: -25px;
        }

        cp_chapter_title {
            font-size: 250px;
            font-weight: 700;
            left: 50px;
            bottom: 100px;
            color: white;
        }

        cp_texts {
            top: 147;
            left: 1020px;
            width: 568px;
            display: flex;
            flex-direction: column;
        }

        cp_texts * {
            position: relative !important;
        }

        cp_title {
            font-size: 100px;
            font-weight: 700;
            color: black;
        }

        .cp_text {
            font-size: 16px;
            line-height: 25px;
        }

        cp_pantone_notice {
            font-size: 12px !important;
            line-height: 18px !important;
        }

        cp_container {
            top: 55px;
            bottom: 81px;
            left: 430px;
            right: 50px;
            display: flex;
            flex-wrap: wrap;
            background-color: #EEE;
            align-items: center;
            justify-content: center;
        }

        cp_container * {
            position: relative !important;
        }

        cp_color_bars {
            height: 28px;
            display: flex;
            margin: 30px 0;
        }

        .cp_block {
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
        }

    </style>
    @foreach ($themeHelper->pagesFor('colorPalette', $page) as $side => $page)
        <div class="page-break pbb{{ $page }}"></div>
        <div id="page{{ $page }}">
            <div
                    class="page_wide {{ $side }}"
                    style="background: {{ 0 < 2 ? '#999999' : 'white' }}">

                <hr class="roof" style="width: 1000px; left: auto;">
                <hr class="basement">

                <pageNumber>{{ sprintf('%02d', $page) }}</pageNumber>
                <basementBrand></basementBrand>
                <cp_chapter class="custom_title">4</cp_chapter>
                <cp_chapter_title class="custom_title">
                    @switch(app()->getLocale())
                        @case('ja')
                        色
                        @break
                        @default
                        Color
                    @endswitch
                    {{-- // FIX until resolving translation issue: 'themes.color' --}}
                </cp_chapter_title>
                <pageInteriorMini class="right cp_block">
                    <cp_title
                            class="custom_title title"
                            contenteditable="true" @blur="title_changed()" data-title-field="pallette_title">
                        {{ $data->pallette_title ?: __('themes.color_palette') }}
                    </cp_title>
                    <div class="text cp_text" data-field="pallette_text">
                        @if(!empty($data->pallette_text))
                            {!!$data->pallette_text!!}
                        @else
                            <p>{!! trans('themes.the_colors_selected', ['brand' => $data->brand]) !!}</p>
                        @endif
                    </div>

                    <cp_pantone_notice class="custom_text">
                        {!! trans('themes.instead_of_the_colors') !!}
                    </cp_pantone_notice>

                    <cp_color_bars>
                        <cp_bar_primary style="flex: 2" class="primary_background"></cp_bar_primary>
                        <cp_bar_secondary style="flex: 2" class="secondary_background"></cp_bar_secondary>
                        <cp_bar_tetriatry style="flex: 1" class="tetriatry_background"></cp_bar_tetriatry>
                    </cp_color_bars>
                </pageInteriorMini>

            </div>
            @if($data->watermark)
                <img class="watermark-draft" src="{{$watermark}}">
            @endif
        </div>
    @endforeach

    <style>
        cp_colors {
            top: 121px;
            left: 50px;
            right: 50px;
            bottom: 100px;
            display: flex;
            flex-direction: row;
            justify-content: {{ $data->colors_list > 4 ? 'space-between' : 'space-around' }};
            align-items: flex-end;
        }

        cp_colors * {
            position: relative !important;
        }

        cp_color {
            width: 150px;
            display: flex;
            flex-direction: column;
        }

        cp_color table {
            font-size: 10px;
            width: 150px;
        }

        cp_background {
            display: flex;
            flex-grow: 1;
            justify-content: flex-end;
            flex-direction: column;
            border-radius: 0px 51.5px 0px 0px;
        }

        cp_shade {
            color: white;
        }

        cp_color_title {
            transform: rotate(90deg);
            right: -20px;
            margin-bottom: -15px;
            text-align: right;
            transform: rotate(90deg);
            transform-origin: right top;
            font-size: 16px;
            font-weight: 700;
            white-space: nowrap;
        }

        cp_shade {
            font-size: 12px;
            color: #FFF;
            font-weight: 700;
            padding: 10px;
            text-align: center;
        }

        cp_color_head {
            font-size: 22px;
            white-space: nowrap;
            margin-bottom: 10px;
        }


    </style>
    @foreach ($themeHelper->pagesFor('colorSamples', $page) as $side => $page)
        <div class="page-break pbb{{ $page }}"></div>
        <div id="page{{ $page }}">
            <div class="page_wide {{ $side }}">

                <hr class="roof">
                <hr class="basement">
                @if($side == 'right')
                    <pageNumber>{{ sprintf('%02d', $page) }}</pageNumber>
                @endif
                <basementBrand></basementBrand>

                <cp_colors>
                    @foreach ($data->colors_list as $color_index => $color)
                        <cp_color style="height: @if(
                            ($height = 600 - ($color_index * 100)) &&
                            $height >= 300
                            ) {{ $height }}px; @else 300px @endif">
                            <cp_color_head>
                                @switch($color_index+1)
                                    @case(1)
                                    {{ __('themes.primary_color') }}
                                    @break
                                    @case(2)
                                    {{ __('themes.secondary_color') }}
                                    @break
                                    @case(3)
                                    {{ __('themes.tertiary_color') }}
                                    @break
                                    @default
                                    {{ __('themes.color_enumeration', ['num' => $color_index+1]) }}

                                @endswitch
                            </cp_color_head>
                            <cp_background style="background-color: {{ $color->id }}">
                                @if(isset($color->show_shades) && $color->show_shades)
                                    @foreach ([-30, 0, 30, 60] as $shade)
                                        @php
                                            $bg = ThemeHelper::adjustBrightness($color->color->hex->value, $shade);
                                        @endphp
                                        <cp_shade style="
                                                background: {{ $bg }};
                                                color: {{ $themeHelper->getContrastColor($bg) }}
                                                ">
                                            {{ strtoupper($bg) }}
                                        </cp_shade>
                                    @endforeach
                                @endif
                            </cp_background>
                            <cp_color_title dir="rtl">{{ $color->color->name->value }}</cp_color_title>

                            <table class="cp_color_values" width="100">
                                <tr>
                                    <td width="50%">Hex</td>
                                    <td>{{ $color->color->hex->value }}</td>
                                </tr>
                                <tr>
                                    <td width="50%">RGB</td>
                                    <td>
                                        {{ $color->color->rgb->r }}
                                        {{ $color->color->rgb->g }}
                                        {{ $color->color->rgb->b }}
                                    </td>
                                </tr>
                                <tr>
                                    <td width="50%">CMYK</td>
                                    <td>
                                        {{ $color->color->cmyk->c }}
                                        {{ $color->color->cmyk->m }}
                                        {{ $color->color->cmyk->y }}
                                        {{ $color->color->cmyk->k }}
                                    </td>
                                </tr>
                                @if(property_exists($color, 'pantone') && $color->pantone!=null)
                                    <tr>
                                        <td>{{trans('themes.pantone')}}</td>
                                        <td>{{ $color->pantone->getName() }}</td>
                                    </tr>
                                @endif
                            </table>
                        </cp_color>
                    @endforeach
                </cp_colors>
            </div>
            @if($data->watermark)
                <img class="watermark-draft" src="{{$watermark}}">
            @endif
        </div>
    @endforeach
@endsection

@section('bookFont')
    <style>
        {!! $themeHelper->fontFaceStyles() !!}
        ft_chapter {
            color: white;
            font-size: 700px;
            font-weight: 700;
            left: -50px;
            top: -190px;
        }

        ft_title {
            color: white;
            font-size: 228px;
            left: 50px;
            bottom: 55px;
            font-weight: 700;
        }

        ft_fonts {
            top: -25px;
            left: 700px;
            white-space: nowrap;
        }

        ft_fonts * {
            position: relative !important;
        }

        bigFonts {
            font-size: 433px;
            line-height: 433px;
            font-weight: 700;
            display: block;
            position: relative !important;
            white-space: nowrap;
        }

        bigFonts * {
            position: relative !important;
        }

        bigFont.secondary1 {
            margin-left: -150px;
        }

        .primary_font {
            font-family: main1;
        }

        .secondary_font {
            font-family: secondary1;
        }

        smallFonts, bigFonts {
            top: -50px;
        }

        smallFonts {
            font-size: 26px;
            line-height: 26px;
            display: block;
            position: relative !important;
        }

        smallFonts * {
            position: relative !important;
        }

    </style>
    @foreach ($themeHelper->pagesFor('bookFont', $page) as $side => $page)
        <div class="page-break pbb{{ $page }}"></div>
        <div id="page{{ $page }}" class="inverted">
            <div class="page_wide {{ $side }} black_background">
                <hr class="roof" style="width: 1000px; left: auto;">
                <hr class="basement">
                <pageNumber>{{ sprintf('%02d', $page) }}</pageNumber>
                <basementBrand></basementBrand>

                <ft_chapter class="custom_title">5</ft_chapter>
                <ft_title class="custom_title">{{trans('themes.font')}}</ft_title>
                {{-- <ft_fonts>
                    <bigFonts>
                        @foreach ($themeHelper->fonts() as $key => $font)
                            <bigFont class="{{ $key }}1 {{ $font['class'] }}">
                                Aa
                            </bigFont>
                        @endforeach
                    </bigFonts>
                    <smallFonts>
                        @foreach ($themeHelper->fonts() as $key => $font)
                            <smallFont class="{{ $key }}1 {{ $font['class'] }}">
                                {{ $font['name'] }}
                                @if ($loop->first)/@endif
                            </smallFont>
                        @endforeach
                    </smallFonts>
                </ft_fonts> --}}

                <pageInteriorMaxi class="right">
                    <bigFonts>
                        @foreach ($themeHelper->fonts() as $key => $font)
                            <bigFont class="{{ $key }}1 {{ $font['class'] }}">
                                Aa
                            </bigFont>
                        @endforeach
                    </bigFonts>
                    <smallFonts>
                        @foreach ($themeHelper->fonts() as $key => $font)
                            <smallFont class="{{ $key }}1 {{ $font['class'] }}">
                                {{ $font['name'] }}
                                @if ($loop->first)/@endif
                            </smallFont>
                        @endforeach
                    </smallFonts>
                </pageInteriorMaxi>

                <pageInteriorMini class="right" style="margin-top:auto">
                    <div class="white_color custom_text"
                         style="line-height: 25px; padding-bottom:50px; margin-top: auto;">
                        @if(isset($data->fonts_main) && isset($data->fonts_main[1]))
                            {{trans('themes.the_primary_font_is')}}
                            {{$data->fonts_main[1]['font_face']}}
                            {{trans('themes.and_it_has')}}
                            {{count($data->fonts_main)}}
                            {{ trans('themes.' . Str::plural('weight', count($data->fonts_secondary)))}}:
                            @if(count($data->fonts_main)==4)
                                {{$data->fonts_main[2]['weight']}}, {{$data->fonts_main[1]['weight']}}
                                {{trans('themes.&')}} {{$data->fonts_main[3]['weight']}}
                            @elseif(count($data->fonts_main)==3)
                                {{$data->fonts_main[1]['weight']}} {{trans('themes.&')}} {{$data->fonts_main[2]['weight']}}
                            @else
                                {{$data->fonts_main[1]['weight']}}
                            @endif.
                        @endif
                        @if(isset($data->fonts_secondary) && isset($data->fonts_secondary[1]))
                            {{trans('themes.our_secondary_font_is')}} {{$data->fonts_secondary[1]['font_face']}} {{trans('themes.and_it_has')}}
                            {{count($data->fonts_secondary)}} {{ trans('themes.' . Str::plural('weight', count($data->fonts_secondary)))}}
                            :
                            @if(count($data->fonts_secondary)==3)
                                {{$data->fonts_secondary[2]['weight']}},
                                {{$data->fonts_secondary[1]['weight']}} {{trans('themes.&')}} {{$data->fonts_secondary[3]['weight']}}
                            @elseif(count($data->fonts_secondary)==2)
                                {{$data->fonts_secondary[1]['weight']}}
                                @if(isset($data->fonts_secondary[2])) {{trans('themes.&')}} {{$data->fonts_secondary[2]['weight']}}
                                @endif
                            @else
                                {{$data->fonts_secondary[1]['weight']}}
                            @endif.
                        @endif
                    </div>

                </pageInteriorMini>
            </div>
            @if($data->watermark)
                <img class="watermark-draft" src="{{$watermark}}">
            @endif
        </div>
    @endforeach
    <style>
        fonts_container {
            display: flex;
            flex-direction: column;
            padding-top: 30px;
        }

        font_container {
            display: flex;
            flex-direction: row;
            align-items: flex-end;
            height: 50%;
        }

        font_primary_container {
            border-bottom: solid 1px black;
        }

        font_info {
            display: flex;
            flex-direction: column;
            width: 240px;
        }

        font_sample {
            font-size: 240px;
            line-height: 240px;
            font-weight: 700;
            margin-left: -60px;
        }

        font_samples {
            width: 350px;
            overflow: hidden;
            margin: 50px;
        }

    </style>
    @foreach ($themeHelper->pagesFor('bookFont', $page) as $side => $page)
        <div class="page-break pbb{{ $page }}"></div>
        <div id="page{{ $page }}" class="">
            <div class="page_wide {{ $side }}">
                <hr class="roof">
                <hr class="basement">
                @if($side == 'right')
                    <pageNumber>{{ sprintf('%02d', $page) }}</pageNumber>
                @endif
                <basementBrand></basementBrand>
                <pageInterior>
                    {{-- <fonts_container> --}}
                    @foreach ($themeHelper->fonts() as $key => $fonts)

                        <font_container>

                            <font_info class="h100" style="padding-top: 10px;">
                                <font_name>
                                    {{ $font['text'] }}
                                    <br>
                                    <font_title class="{{ $key }}1" style="
                                    @if(strlen($fonts['name']) > 10)
                                            font-size:26px;line-height:26px;
                                    @else
                                            font-size:36px;line-height:36px;
                                    @endif
                                            ">
                                        {{ $fonts['name'] }}
                                    </font_title>
                                </font_name>
                                <font_sample class="{{$key}}1 {{ $fonts['class'] }}">
                                    Aa
                                </font_sample>
                            </font_info>

                            @foreach($fonts['fonts'] as $fm)
                                @if(isset($fm['index']))
                                    @php
                                        $fontClass = $key . $fm['index'];
                                    @endphp
                                    <font_samples class="fonts2-weight {{ $fontClass }}">
                                        <font_title
                                                class="fonts2-weight {{ $fontClass }} {{ $fonts['class'] }}" style="
                                        @if(strlen($fonts['fonts'][1]['font_face']) >= 10)
                                                font-size: 22px; line-height: 22px;
                                        @else
                                                font-size: 32px; line-height: 32px;
                                        @endif
                                                ">

                                            {{ $fonts['fonts'][1]['font_face'] }}
                                            @if(isset($fm['weight']))
                                                {{$fm['weight']}}
                                            @endif
                                        </font_title>
                                        <div
                                                class="fonts2-weight {{ $fontClass }}"
                                                style="font-size: 60px; line-height: 60px;overflow: hidden; width: 1000px;">
                                            ABCDEFG
                                            <br>
                                            {{ $data->brand }} Brand
                                        </div>
                                        <div class="fonts2-weight {{ $fontClass }}"
                                             style="font-size: 20px; line-height: 20px;">
                                            abcdefghijklmnopqrstuvwxyz
                                        </div>
                                        <div class="fonts2-weight {{ $fontClass }}">
                                            0123456789!@#$%^&*
                                        </div>
                                    </font_samples>
                                @endif
                            @endforeach
                        </font_container>
                        @if($loop->first)
                            <line style="border:solid 1px;background:black;margin:-10px 0 10 0;"></line>
                        @endif
                    @endforeach
                    {{-- </fonts_container> --}}
                </pageInterior>
            </div>
            @if($data->watermark)
                <img class="watermark-draft" src="{{$watermark}}">
            @endif
        </div>
    @endforeach
@endsection

@php
    $page = $themeHelper->adjustPageNumberForMockups($page);
@endphp

@section('bookAuthor')
    <style>
        .creator_section {
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
        }

        user_headline {
            display: flex;
            flex-direction: row;
        }

        user_headline img {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
            border: solid 2px white;
            margin-right: 25px;
        }

        user_titles {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        user_details {
            padding-top: 30px;
            padding-bottom: 30px;
            font-size: 16px;
            display: flex;
        }

        user_description {
            width: 500px;
            margin-right: 80px;
        }

        user_contacts .icon {
            margin-right: 5px;
            display: inline-block;
        }

        user_contacts {
            font-size: 11px;
            color: white;
            width: 225px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            line-height: 16px;
        }
    </style>
    @foreach ($themeHelper->pagesFor('bookAuthor', $page) as $side => $page)
        <div class="page-break pbb{{ $page }}"></div>
        <div id="page{{ $page }}">
            <div class="page_wide {{ $side }} inverted" style="background: #999;">
                <hr class="roof">
                <hr class="basement">
                <pageNumber>{{ sprintf('%02d', $page) }}</pageNumber>
                <basementBrand></basementBrand>
                <pageInteriorHalf class="right creator_section">
                    <user_headline>
                        <img src="{{$data->user->avatar}}">
                        <user_titles>
                            <user_name style="font-size: 18px">
                                <strong>{{$data->user->name}}</strong>
                                @if($data->user->position)
                                    | {{$data->user->position}}
                                @endif
                            </user_name>
                            <h1 style="margin: 0">{{trans('themes.brand_book_designer')}}</h1>
                        </user_titles>
                    </user_headline>
                    <user_details>
                        <user_description class="custom_text">
                            {!! nl2br($data->user->description) !!}
                        </user_description>
                        <user_contacts>
                            <user_social>
                                {{$data->user->company_web}}
                                <br>
                                @if(!empty($data->user->company_dribble))
                                    <i class="fa fa-dribbble icon"></i>{{$data->user->company_dribble}}
                                    <br>
                                @endif
                                @if(!empty($data->user->company_behance))
                                    <i class="fa fa-behance"
                                       style="margin-right: 5px; display: inline-block;"></i>{{$data->user->company_behance}}
                                @endif
                            </user_social>

                            <user_contact>
                                @if(!empty($data->user->company_phone) || !empty($data->user->email))
                                    {{trans('themes.contact')}}
                                    <br>
                                    @if(!empty($data->user->company_phone))
                                        <i class="fa fa-mobile icon"></i>{{$data->user->company_phone}}
                                        <br>
                                    @endif
                                    @if(!empty($data->user->email))
                                        <i class="fa fa-envelope icon"></i>{{$data->user->email}}
                                    @endif
                                @endif
                            </user_contact>

                            <company_logo>
                                <img src="{{ $data->user->company_logo_full }}"
                                     style="filter: brightness(0) invert(1); height:30px;">
                            </company_logo>

                        </user_contacts>
                    </user_details>
                </pageInteriorHalf>
            </div>
            @if($data->watermark)
                <img class="watermark-draft" src="{{$watermark}}">
            @endif
        </div>
    @endforeach
@endsection

@if($data->user->company_logo_full)
@section('bookCompany')
    @foreach ($themeHelper->pagesFor('bookAuthor', $page) as $side => $page)
        <div class="page-break pbb{{ $page }}"></div>
        <div id="page{{ $page }}">
            <div class="page_wide {{ $side }}">
                <hr class="roof">
                <hr class="basement">
                <pageNumber>{{ sprintf('%02d', $page) }}</pageNumber>
                <basementBrand></basementBrand>
                <pageInteriorHalf class="{{ $side }}">
                    @if($side == 'left')
                        <vtable>
                            <valign style="text-align:center">
                                <div style="font-size: 14px; margin-bottom: 30px">
                                    {{trans('themes.designed_by')}}
                                </div>
                                <img src="{{ $data->user->company_logo_full }}" width="200px">
                            </valign>
                        </vtable>
                    @else
                        <vtable>
                            <valign style="text-align: right;vertical-align: bottom;">
                                <div style="font-size: 14px; margin-bottom: 30px">
                                    <svg width="19" height="19" viewBox="0 0 19 19" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                                d="M0 0.613281V18.9087H18.2955V0.613281H0ZM10.5387 15.9924C8.22929 16.3858 5.76819 15.8045 3.83729 14.1841L5.47034 12.2373C6.92794 13.4605 8.82042 13.8244 10.5385 13.3947L10.5387 15.9924ZM10.5387 6.5615C10.1906 6.18754 9.69586 5.95208 9.14553 5.95208C8.09464 5.95208 7.23969 6.80702 7.23969 7.85755C7.23969 8.90844 8.09446 9.76357 9.14553 9.76357C9.69568 9.76357 10.1904 9.52792 10.5387 9.15396V12.0778C10.1 12.2232 9.63237 12.3044 9.14553 12.3044C6.69357 12.3044 4.69864 10.3097 4.69864 7.85737C4.69864 5.40559 6.69357 3.41084 9.14553 3.41084C9.63237 3.41084 10.0998 3.49207 10.5387 3.63752V6.5615Z"
                                                fill="black"/>
                                    </svg>

                                    {{trans('themes.powered_by')}} gingersause
                                </div>
                            </valign>
                        </vtable>
                    @endif
                </pageInteriorHalf>
            </div>
            @if($data->watermark)
                <img class="watermark-draft" src="{{$watermark}}">
            @endif
        </div>
    @endforeach
@endsection
@endif

@php
    $page++;
@endphp

@section('backCover')
    <style>
        brandNameBack {
            font-size: 32px;
            font-weight: 700;
            line-height: 46px;
            color: white;
            text-align: center;
            padding-left: 50px;
        }

    </style>
    <div class="page-break pbb{{ $page }}"></div>
    <div id="page{{ $page }}">
        <div class="page_wide {{ $side }} black_background">
            <pageNumber>{{ sprintf('%02d', $page) }}</pageNumber>
            <basementBrand></basementBrand>
            <pageInteriorHalf class="{{ $side }} toMiddle">
                <brandNameBack>{{$data->brand}} {{ trans('themes.brand_book') }}</brandNameBack>
            </pageInteriorHalf>
            <pageInteriorHalf class="{{ $side }} toBottom">
                <div style="display: none; font-size: 14px; margin-bottom: 30px; color: white;text-align:center;padding-left:50px">
                    <svg width="19" height="19" viewBox="0 0 19 19" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path
                                d="M0 0.613281V18.9087H18.2955V0.613281H0ZM10.5387 15.9924C8.22929 16.3858 5.76819 15.8045 3.83729 14.1841L5.47034 12.2373C6.92794 13.4605 8.82042 13.8244 10.5385 13.3947L10.5387 15.9924ZM10.5387 6.5615C10.1906 6.18754 9.69586 5.95208 9.14553 5.95208C8.09464 5.95208 7.23969 6.80702 7.23969 7.85755C7.23969 8.90844 8.09446 9.76357 9.14553 9.76357C9.69568 9.76357 10.1904 9.52792 10.5387 9.15396V12.0778C10.1 12.2232 9.63237 12.3044 9.14553 12.3044C6.69357 12.3044 4.69864 10.3097 4.69864 7.85737C4.69864 5.40559 6.69357 3.41084 9.14553 3.41084C9.63237 3.41084 10.0998 3.49207 10.5387 3.63752V6.5615Z"
                                fill="white"/>
                    </svg>

                    {{trans('themes.powered_by')}} gingersause
                </div>
            </pageInteriorHalf>
        </div>
        @if($data->watermark)
            <img class="watermark-draft" src="{{$watermark}}">
        @endif
    </div>
@endsection

@if($data->mockups)
    <style>
        mockupImage {
            width: 100%;
            height: 100%;
            background-size: contain;
            background-position: left;
            background-repeat: no-repeat;
        }

        mockupImage.full {
            background-size: cover;
            background-position: center;
        }

        mockupTitle {
            top: 0;
            right: 0;
            width: 250px;
            padding-right: 50;
            display: flex;
            display: flex;
            flex-direction: column;
            height: 100%;
            justify-content: center;
            background: white;
            padding-left: 30px;
        }
    </style>
    @foreach ($data->mockups as $index => $mockup)
        @continue(!isset($mockup->image) || !$mockup->image)
@section('bookMockups'.$index)
    @foreach ($themeHelper->pagesFor('bookMockups', $page) as $side => $page)
        <div class="page-break pbb{{ $page }}"></div>
        <div id="page{{ $page }}">
            <div class="page_wide {{ $side }}">
                <mockupImage
                        style="background-image: url({{ $mockup->image }})"
                        class="{{ $mockup->title ? '' : 'full' }}">
                </mockupImage>
                @if($mockup->title)
                    <mockupTitle>
                        {{ $mockup->title }}
                    </mockupTitle>
                @endif
            </div>
            @if($data->watermark)
                <img class="watermark-draft" src="{{$watermark}}">
            @endif
        </div>
    @endforeach
@endsection
@endforeach
@endif

@section('bookContents')
    <style>
        contents {
            left: 760px;
            bottom: 100px;
            right: 50px;
        }

        contents page {
            font-size: {{ app()->getLocale() == 'ja' ? 65 : 80  }}px;
            font-weight: 700;
            width: 710px;
            display: block;
            position: relative !important;
        }

        contents page span {
            right: 0;
            bottom: 15px;
            font-size: 34px;
            font-weight: 400;
        }
    </style>
    @foreach (['left' => 2, 'right' => 3] as $side => $page)
        <div class="page-break pbb{{ $page }}"></div>
        <div id="page{{ $page }}">
            <div class="page_wide {{ $side }}">
                <hr class="roof">
                <hr class="basement">
                <basementBrand></basementBrand>
                @if($side == 'right')
                    <pageNumber>{{ sprintf('%02d', $page) }}</pageNumber>
                    <contents>
                        <page>
                            1 {{trans('themes.introduction')}}
                            <span>
                        __{{ $themeHelper->pageNumbers['bookIntro'] }}
                    </span>
                        </page>
                        <page class="primary_color">
                            2 {{trans('themes.logo')}}
                            <span>
                        __{{ $themeHelper->pageNumbers['bookLogo'] }}
                    </span>
                        </page>
                        <page class="secondary_color">
                            3 {{trans('themes.guidelines')}}
                            <span>
                        __{{ $themeHelper->pageNumbers['bookGuidelines'] }}
                    </span>
                        </page>
                        <page class="grey_color">
                            4 {{ app()->getLocale() == 'ja' ? '色' : 'Color' }}
                            {{-- // FIX until resolving translation issue: 'themes.color' --}}
                            <span>
                                __{{ $themeHelper->pageNumbers['colorPalette'] }}
                            </span>
                        </page>
                        <page>
                            5 {{trans('themes.font')}}
                            <span>
                        __{{ $themeHelper->pageNumbers['bookFont'] }}
                    </span>
                        </page>
                    </contents>
                @endif
            </div>
            @if($data->watermark)
                <img class="watermark-draft" src="{{$watermark}}">
            @endif
        </div>
    @endforeach
@endsection

{{-- Assembling --}}
@yield('prefrontCover')

@if($data->custom_logo)
    @yield('frontCoverCustom')
@else
    @yield('frontCover')
@endif

@yield('bookContents')
@yield('bookIntro')
@yield('bookMockups0')
@yield('bookVision')
@yield('bookMission')
@yield('coreValues')
@yield('voices')
@yield('bookLogo')
@yield('bookMockups1')
@yield('bookIcon')
@yield('bookGuidelines')
@yield('clearSpace')
@yield('minimumSize')
@yield('bookMockups2')
@yield('logoMisuse')
@yield('featureIcons')
@yield('colorPalette')
@yield('bookFont')
@yield('bookMockups3')
@yield('bookAuthor')
@yield('bookCompany')
@yield('backCover')

@include('js.text-autogrow')
</body>
</html>
