<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomLayout extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'custom_layouts';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'font_family_default',
        'primary_color',
        'primary_opacity_color',
        'secundary_color',
        'gray_dark_color',
        'gray_light_color',
        'gray_medium_color',
        'gray_over_color',
        'title_color',
        'text_color',
        'sub_text_color',
        'placeholder_color',
        'background_color',

        'background_base',
        'background_base_dark',

        'input_primary',
        'input_primary_dark',

        'carousel_banners',
        'carousel_banners_dark',

        'sidebar_color',
        'sidebar_color_dark',

        'navtop_color',
        'navtop_color_dark',

        'side_menu',
        'side_menu_dark',

        'footer_color',
        'footer_color_dark',

        'card_color',
        'card_color_dark',

        'border_radius',
        'custom_css',
        'custom_js',
    ];

}
