var info_window_template = '<div class="iw-panel <%= iwClass %>">' +
    '<div class="iw-img text-right">' +
    '<a href="<%= mediaUrl %>" onclick=\'CB_Open("href=<%= mediaUrl %>");return false\' rel="clearbox">' +
    '<img src="<%= mediaUrl %>" class="img-responsive img-infowindow"/>' +
    '</a>' +
    '<span class="iw-usertype label label-default"><%= userType %></span>' +
    '</div>' +
    '<div class="iw-content">' +
    '<%= content %>' +
    '</div>' +
    '<div class="clearfix"></div>' +
    '</div>';
