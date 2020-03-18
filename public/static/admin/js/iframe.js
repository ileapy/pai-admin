var iframe = function(){

    /**
     * 页面load
     */
    var build = function($title,$url,$param) {
        jQuery('body').prepend(
            '<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModal" data-backdrop="static">\n' +
            '    <div class="modal-dialog modal-lg" role="document">\n' +
            '        <div class="modal-content">\n' +
            '            <div class="modal-header">\n' +
            '                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>\n' +
            '                <h4 class="modal-title" id="exampleModalLabel">'+$title+'</h4>\n' +
            '            </div>\n' +
            '            <div class="modal-body">\n' +
            '              <iframe src="'+$url+'" style="width: 100%;border: 0px;height: 100%;"></iframe>'+
            '            </div>\n' +
            '                <div class="modal-footer">\n' +
            '                  <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>\n' +
            '                </div>'+
            '        </div>\n' +
            '    </div>\n' +
            '</div>'
        );
    };

    var open = function ($title,$url,$param={}) {
        build($title,$url,$param);
        $("#myModal").modal("show");
    };

    return {
        // 页面加载动画
        createIframe : function ($title,$url,$param={}) {
            open($title,$url,$param);
        }
    };
}();