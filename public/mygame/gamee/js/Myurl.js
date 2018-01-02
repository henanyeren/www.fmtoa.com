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
参数类
 */
var Myurl = /** @class */ (function (_super) {
    __extends(Myurl, _super);
    function Myurl() {
        return _super.call(this) || this;
    }
    Myurl.prototype.init = function (_name) {
        this.name = _name;
        var reg = new RegExp("(^|&)" + this.name + "=([^&]*)(&|$)");
        var r = window.location.search.substr(1).match(reg);
        gameInstance.id = r;
    };
    return Myurl;
}(Laya.Sprite));
//# sourceMappingURL=Myurl.js.map