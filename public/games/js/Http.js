/**
请求类
 */
var Http = /** @class */ (function () {
    function Http() {
    }
    Http.prototype.mydata = function () {
        var xhr = new Laya.HttpRequest();
        xhr.http.timeout = 10000; //设置超时时间；
        xhr.once(Laya.Event.COMPLETE, this, this.completeHandler);
        xhr.once(Laya.Event.ERROR, this, this.errorHandler);
        xhr.once(Laya.Event.PROGRESS, this, this.processHandler);
        xhr.send("http://www.fmtoa.com/games/game/boss?id=" + gameInstance.id[2], 'null', 'post', 'json'); //
    };
    Http.prototype.processHandler = function (e) {
        //console.log(3);
    };
    Http.prototype.errorHandler = function (e) {
        //console.log(2);
    };
    Http.prototype.completeHandler = function (e) {
        console.log(e);
        this.data = e;
        this.overurl = e['url'];
        return e;
        // console.log(this.data);
    };
    Http.prototype.datas = function (myhp) {
        window.location.href = this.overurl + "&hp=" + myhp;
    };
    return Http;
}());
var mydatas = new Http();
//# sourceMappingURL=Http.js.map