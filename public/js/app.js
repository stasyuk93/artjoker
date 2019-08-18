function ChosenTerritory(obj) {
    this.selector = null;
    this.childSelector = null;
    this.childSelectorContainer = null;
    this.name = null;
    this.callback = null;
    this.initConstructor(obj);
}
ChosenTerritory.prototype.initConstructor = function(obj){
    for (var prop in obj) {
        if (this.hasOwnProperty(prop)) {
            this[prop] = obj[prop];
        }
    }
};
ChosenTerritory.prototype.init = function(){
    this.getChildTerritory();
};
ChosenTerritory.prototype.changeCallback = function(){
    if(typeof this.callback === 'function') return this.callback();
};
ChosenTerritory.prototype.createOption = function (data) {
    var options = [$("<option/>")];
    $.each(data, function (key, value) {
        options.push(
            $("<option/>", {
                text: value['ter_name'],
                value: value['ter_id']
            })
        ) ;
    });
    $(this.childSelectorContainer).show();
    $(this.childSelector).html(options).chosen().trigger("chosen:updated");
};
ChosenTerritory.prototype.getChildTerritory = function () {
    var _this = this;
    $(this.selector).chosen({width: "100%"}).change(function(){
        if(_this.name) this.name = _this.name;
        $(_this.childSelectorContainer).hide();
        _this.changeCallback();
        var terId = $(_this.selector).chosen().val();
        $.get( "/territory/"+terId+"/children", function( data ) {
            if(data){
                _this.createOption(data);
            }
        });
    });
};

new ChosenTerritory({
    selector:'#region',
    childSelector:'#city',
    childSelectorContainer:'#city-container',
    callback:function () {
        $('#locality-container').hide();
        $('#town-container').hide();
    }
}).init();
new ChosenTerritory({
    selector:'#city',
    childSelector:'#locality',
    childSelectorContainer:'#locality-container',
    name:'city_id',
    callback:function () {
        $('#town-container').hide();
        $('#locality').attr('name','');
        $('#town').attr('name','');
    }
}).init();
new ChosenTerritory({
    selector:'#locality',
    childSelector:'#town',
    childSelectorContainer:'#town-container',
    name:'city_id',
    callback:function () {
        $('#town').change(function (e) {
            this.name = 'city_id';
        });
    }
}).init();
