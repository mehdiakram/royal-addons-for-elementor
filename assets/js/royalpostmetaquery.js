(function($) {
    var RoyalPostMetaQuery = function($scope, $) {
    // Make sure we run this code under Elementor
        var $_this          = $scope.find('.royalpostmetaquery');
        let queryid         = '#'+$_this.attr('id');
        let orderno         = $_this.data('orderno');
        let orderby         = $_this.data('orderby');
        let dropdown        = $_this.data('dropdown');
        let dropdowntitle   = $_this.data('dropdowntitle');
        let dropdownwidth   = $_this.data('dropdownwidth');

        let findqueryid     = document.querySelector(queryid);

        let royaldatatables = document.querySelector('.royaldatatables');
        if(royaldatatables){
        let targetdropdown  = findqueryid.querySelector('thead tr th:nth-child( ' + dropdown + ')');
        $(targetdropdown).append( "<span class=datatabledropdown></span>" );
        $(queryid).DataTable({
            "order": [[ orderno, orderby ]],
              "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
              initComplete: function () {
                                  this.api().columns().every( function () {
                                      var column = this;
                                      var select = $('<br><select style="width:'+dropdownwidth+'px;"><option value="">'+ dropdowntitle +'</option></select>')
                                          .appendTo( $(column.header()).find('.datatabledropdown').empty() )
                                          .on({ 'change': function () {
                                              var val = $.fn.dataTable.util.escapeRegex(
                                                  $(this).val()
                                              );
                      
                                              column
                                                  .search( val ? '^'+val+'$' : '', true, false )
                                                  .draw();
                                          },
                                          'click': function(e) {
                                          // stop click event bubbling
                                          e.stopPropagation();
                                          }
                                          } );
                      
                                      column.data().unique().sort().each( function ( d, j ) {
                                            var textVal = d.replace(/<a\b[^>]*>(.*?)<\/a>/i,"$1");
                                            select.append( '<option value="'+textVal+'">'+textVal+'</option>' )
                                      } );
                                  } );
                              }
          });
        }


    // Make sure we run this code under Elementor
    };
    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/royalpostmetaquery.default', RoyalPostMetaQuery);
    });
})(jQuery);