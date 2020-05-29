import router from "../router";
import cookie from "../utils/cookie";
import store from "../store";

export default function toLogin(backPath) {
    console.log(store.state.isLogin)
    if (store.state.isLogin) return;
    const { fullPath } = router.currentRoute;
    cookie.set("login_back_url", backPath || fullPath);
    // 登录
    router.replace({ path: "/author" })
}
