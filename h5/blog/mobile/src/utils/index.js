export function isWeixin() {
    return navigator.userAgent.toLowerCase().indexOf("micromessenger") !== -1;
}

export function isAndroid() {
    return navigator.userAgent.toLowerCase().indexOf("android") !== -1;
}

export function isIos() {
    return navigator.userAgent.toLowerCase().indexOf("iphone") !== -1 || (navigator.userAgent.toLowerCase().indexOf('ipad') != -1);
}

export const _URL = "https://learn.leapy.cn";
export const _URL_API = "https://learn.leapy.cn/api"