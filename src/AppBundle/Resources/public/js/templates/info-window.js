var info_window_template = '<div class="iw-panel <%= iwClass %>">' +
    '<div class="iw-img">' +
    '<a href="<%= mediaUrl %>" onclick=\'CB_Open("href=<%= mediaUrl %>");return false\' rel="clearbox">' +
    '<img src="<%= mediaUrl %>" class="img-responsive img-infowindow"/>' +
    '</a>' +
    '</div>' +
    '<div class="iw-content">' +
    '<%= content %>' +
    '</div>' +
    '</div>';
