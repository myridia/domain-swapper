( function( api ) {

    // Extends our custom "example-1" section.
    api.sectionConstructor['pro-section'] = api.Section.extend( {

        // No events for this type of section.
        attachEvents: function () {},

        // Always make the section active.
        isContextuallyActive: function () {
            return true;
        }
    } );

} )( wp.customize );

jQuery(document).ready(function($){

    wp.customize.section( 'sidebar-widgets-header-widget' ).panel( 'frontpage_settings' );
    wp.customize.section( 'sidebar-widgets-header-widget' ).priority( '40' );

    //Scroll to front page section
    $('body').on('click', '#sub-accordion-panel-frontpage_settings .control-subsection .accordion-section-title', function(event) {
        var section_id = $(this).parent('.control-subsection').attr('id');
        scrollToSection( section_id );
    }); 
    
});

function scrollToSection( section_id ){

    var preview_section_id = "banner_section";

    var $contents = jQuery('#customize-preview iframe').contents();

    switch ( section_id ) {
    
        case 'accordion-section-best_shop_blog_posts':
        preview_section_id = "blog_section";
        break;

        case 'accordion-section-best_shop_editor_posts':
        preview_section_id = "editor_section";
        break;

        case 'accordion-section-instagram_section':
        preview_section_id = "instagram_section";
        break;

        case 'accordion-section-sidebar-widgets-header-widget':
        preview_section_id = "advertisement";
        break;

        case 'accordion-section-best_shop_newsletter':
        preview_section_id = "newsletter_section";
        break;

        case 'accordion-section-sort_home_sections':
        preview_section_id = "banner_section";
        break;
    }

    if( $contents.find('#'+preview_section_id).length > 0 && $contents.find('.home').length > 0 ){
        $contents.find("html, body").animate({
        scrollTop: $contents.find( "#" + preview_section_id ).offset().top
        }, 1000);
    }
}