var __extends = (this && this.__extends) || (function () {
    var extendStatics = Object.setPrototypeOf ||
        ({ __proto__: [] } instanceof Array && function (d, b) { d.__proto__ = b; }) ||
        function (d, b) { for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p]; };
    return function (d, b) {
        extendStatics(d, b);
        function __() { this.constructor = d; }
        d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
    };
})();
/**
 * 游戏UI类
 */
var GameStart = /** @class */ (function (_super) {
    __extends(GameStart, _super);
    function GameStart() {
        var _this = _super.call(this) || this;
        //注册按钮点击事件，点击之后暂停游戏
        _this.start.on(Laya.Event.CLICK, _this, _this.onPauseBtnClick);
        return _this;
        //初始化UI显示
    }
    GameStart.prototype.onPauseBtnClick = function (e) {
        this.removeSelf();
        var url = Laya.Pool.getItemByClass("myurl", Myurl);
        //开始游戏
        //  console.log(mydatas.data+"1");
        //window.location.href="https://www.baidu.com/";
        gameInstance.restart();
    };
    return GameStart;
}(ui.GameStartUI));
//# sourceMappingURL=GameStart.js.map