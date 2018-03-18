(function($) {
    $.widget("custom.inputusuario", {
        _create: function() {
          /*xspan=$("<span>")
          .addClass("custom-combobox");*/
          //console.log(xspan);
          this.wrapper = $("<span>")
          .addClass("custom-combobox")
          .insertAfter(this.element);
          this.element.hide();
          this._loadimput();  
          this._createShowAllButton();
        },
        _loadimput: function() {
           this.input = $("<input>")
          .appendTo(this.wrapper)
          .addClass("custom-combobox-input ui-widget ui-corner-left")
          .attr("id", this.element.attr("id").replace("txt", "wg"))
          .css({ "width": this.element.css("width") });


           
        },

        _createShowAllButton: function() {
          
          var input = this.input,
          wasOpen = false;

          this.a = $("<a>")
          .attr("id", this.element.attr("id").replace("txt", "link"))
          .attr("tabIndex", -1)
          .attr("title", "Buscar Usuario")
          //.tooltip()
          .appendTo(this.wrapper)
          .button({
              icons: {
                  primary: "ui-icon-search"
              },
              text: false
          })
          .removeClass("ui-corner-all")
          .addClass("custom-combobox-toggle ui-corner-right")
          .click(function() {
              alert("Click :P");
          });
        },
        disable: function() {
            this.input.prop('disabled', true);
            this.a.button("disable");
        },
        enable: function() {
            this.input.prop('disabled', false);
            this.a.button("enable");
        }
    });
})(jQuery);