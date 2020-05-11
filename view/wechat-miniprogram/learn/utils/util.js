const formatTime = date => {
  const year = date.getFullYear()
  const month = date.getMonth() + 1
  const day = date.getDate()
  const hour = date.getHours()
  const minute = date.getMinutes()
  const second = date.getSeconds()

  return [year, month, day].map(formatNumber).join('/') + ' ' + [hour, minute, second].map(formatNumber).join(':')
}

const formatNumber = n => {
  n = n.toString()
  return n[1] ? n : '0' + n
}

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

module.exports = {
  formatTime: formatTime,
  request:request
}
