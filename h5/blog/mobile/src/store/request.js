// 请求
const request = function(url,type="GET",data={},isLogin=false)
{
    return new Promise(function(resolve, reject)
    {
        var header = {};
        if (isLogin) header = {"Authori-zation":wx.getStorageSync('token')}
        wx.request({
            url: url,
            method: type,
            data:data,
            header:header,
            success:(res) => {
                if(res.statusCode === 200)
                {
                    if (res.data.status === 410000 || res.data.status === 410001 || res.data.status === 410002) wx.navigateTo({
                        url: '/pages/login/login',
                    });
                    else resolve(res.data);
                }
                else resolve(res)
            },
            fail(res)
            {
                reject(res)
            }
        })
    })
}

export default request;
