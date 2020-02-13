var iframe = function(){

    /**
     * 页面loading
     */
    var pageLoader = function($title,$url,$type,$data) {
        var $e= jQuery('#exampleModal');
        $mode      = $mode || 'show';
        if ($mode === 'show') {
            jQuery('body').prepend('<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">\n' +
                '    <div class="modal-dialog modal-lg" role="document">\n' +
                '        <div class="modal-content">\n' +
                '            <div class="modal-header">\n' +
                '                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>\n' +
                '                <h4 class="modal-title" id="exampleModalLabel">'+$title+'</h4>\n' +
                '            </div>\n' +
                '            <div class="modal-body">\n' +
                                loadData($url,$type,$data)+'\n' +
                '            </div>\n' +
                '        </div>\n' +
                '    </div>\n' +
                '</div>');
        } else if ($mode === 'hide') {
            if ($loadingEl.length) {
                $loadingEl.fadeOut(250);
            }
        }
        return false;
    };

    var loadData = function ($url,$type,$data) {
        if ($type == "POST") $.post(url=$url,data=$data,function (res) {return res;});
        else if($type == "GET") $.get(url=$url,data=$data,function (res) {return res;})
    };

    return {
        // 页面加载动画
        createIframe : function ($title,$url,$type="GET",$data={}) {
            pageLoader($title,$url,$type,$data);
        }
    };
}();