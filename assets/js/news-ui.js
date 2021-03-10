var NwControl = newsSettingsData.NwControl;

jQuery( document ).ready(function() {
    
    // Getting NEWS settings options
    var NwControl = newsSettingsData.NwControl;
    var NwMessage = newsSettingsData.NwMessage;
    var NwTextColor = newsSettingsData.NwTextColor;
    var NwBackground = newsSettingsData.NwBackground;
    var NwMessageLink = newsSettingsData.NwMessageLink;

    var newsBox = document.getElementById("nw-news-box");
    var closeBox = document.getElementById("nw-close");

    // Checking For Cookies
    if (Cookies.get('nw-box-show-user') == 'none') {
        jQuery(newsBox).css('display', 'none')
    }

    // Checking For Controll
    if(NwControl === 'hide'){
        jQuery(newsBox).css('display', 'none');
    }

    // Implimenting NEWS settings options
    jQuery(newsBox).css('background-color', NwBackground);
    jQuery('#nw-msg-link').css('color', NwTextColor);
    jQuery('#nw-msg-link').attr('href', NwMessageLink);
    jQuery('#nw-msg-link').html(NwMessage);

    jQuery(closeBox).click(function(){
        jQuery(newsBox).css('display', 'none');
        Cookies.set('nw-box-show-user', 'none', { expires: 1 })
    });

});

