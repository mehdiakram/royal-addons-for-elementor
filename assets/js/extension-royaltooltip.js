"use strict";

;
(function ($) {
  'use strict';

  var $window = $(window);
  $window.on('elementor/frontend/init', function () {
    var gloablTooltipOptions = [];

    var atomicTypes = ['div-block', 'e-div-block', 'e-flexbox', 'atomic-widget-base',
                       'atomic-heading', 'atomic-image', 'atomic-button', 'atomic-text-editor',
                       'atomic-icon', 'atomic-video', 'atomic-divider', 'atomic-spacer'];

    var AdvancedTooltip = elementorModules.frontend.handlers.Base.extend({

      getAtomicProp: function(key) {
        var $xNode = this.$element.is('[x-data]') ? this.$element : this.$element.find('[x-data]').first();
        var xData = $xNode.length ? ($xNode.attr('x-data') || '') : '';
        
        if (xData.indexOf(key) === -1) return undefined;
        
        var regex = new RegExp('"' + key + '"\\s*:\\s*(true|false|null|"[^"\\\\]*(?:\\\\.[^"\\\\]*)*"|\\d+(?:\\.\\d+)?|\\{[^}]*\\})');
        var match = xData.match(regex);
        if (match) {
            var valStr = match[1];
            if (valStr === 'true') return true;
            if (valStr === 'false') return false;
            if (valStr === 'null') return null;
            if (valStr.charAt(0) === '"') {
                return valStr.slice(1, -1).replace(/\\"/g, '"').replace(/\\\\/g, '\\');
            }
            if (valStr.charAt(0) === '{') {
                var valMatch = valStr.match(/"value"\s*:\s*(true|false|null|"[^"\\\\]*(?:\\\\.[^"\\\\]*)*"|\\d+(?:\\.\\d+)?)/);
                if (valMatch) {
                    var innerVal = valMatch[1];
                    if (innerVal === 'true') return true;
                    if (innerVal === 'false') return false;
                    if (innerVal === 'null') return null;
                    if (innerVal.charAt(0) === '"') {
                        return innerVal.slice(1, -1).replace(/\\"/g, '"').replace(/\\\\/g, '\\');
                    }
                    return Number(innerVal);
                }
            }
            return Number(valStr);
        }
        return undefined;
      },


      isAtomicElement: function() {
        var elType = this.$element.data('element_type') || this.$element.data('widget_type') || '';
        if (elType) {
            elType = elType.split('.')[0];
        }
        var elName = this.$element.attr('class') || '';
        var atomicTypes = ['div-block', 'e-div-block', 'e-flexbox', 'atomic-widget-base',
                           'atomic-heading', 'atomic-image', 'atomic-button', 'atomic-text-editor',
                           'atomic-icon', 'atomic-video', 'atomic-divider', 'atomic-spacer'];
        
        return this.$element.is('[x-data]') ||
               this.$element.find('[x-data]').length > 0 ||
               elName.indexOf('e-div-block') !== -1 ||
               atomicTypes.indexOf(elType) !== -1;
      },

      getSpan: function() {
        // Legacy Container/Section/Column often restructure their DOM and wrap the appended span, requiring .find()
        // Atomic Div Blocks and Widgets do not restructure, and require .children() to avoid stealing child tooltips
        return this.isAtomicElement()
          ? this.$element.children('.royal-tooltip-content')
          : this.$element.find('.royal-tooltip-content:first');
      },

      getRoyalSettings: function() {
        var dataSettings = this.$element.data('settings') || {};
        var royalData = this.$element.data('royal-tooltip');
        if (typeof royalData === 'string') {
            try { royalData = JSON.parse(royalData); } catch(e) { royalData = {}; }
        }
        royalData = royalData || {};
        
        var self = this;
        var getSetting = function(key) {
            var val = royalData[key];
            if (val === undefined || val === null) val = self.getElementSettings(key);
            if (val === undefined || val === null) val = dataSettings[key];
            if (val === undefined || val === null) val = self.getAtomicProp(key);
            return val;
        };

        var enable = getSetting('royal_tooltip_enable');
        var isEnabled = this.$element.hasClass('royal-tooltip-enable') ||
                        enable === true || enable === 'enable' || enable === 'yes';

        if (!isEnabled) return null;

        return {
          enable:    true,
          content:   getSetting('royal_tooltip_content')   || 'I am a tooltip',
          position:  getSetting('royal_tooltip_position')  || 'top',
          animation: getSetting('royal_tooltip_animation') || '',
          duration:  getSetting('royal_tooltip_duration')  || 1000,
          arrow:     getSetting('royal_tooltip_arrow'),
          trigger:   getSetting('royal_tooltip_trigger')   || 'hover',
        };
      },

      onInit: function onInit() {
        elementorModules.frontend.handlers.Base.prototype.onInit.apply(this, arguments);
        var s = this.getRoyalSettings();
        if (!s || !s.enable) return;

        this.$element.addClass('royal-tooltip-enable');
        if (this.getSpan().length === 0) {
          this.$element.append("<span class='royal-tooltip-content'></span>");
        }
        this.run(s);
      },

      onElementChange: function onElementChange(e) {
        var style_controls = ['royal_tooltip_enable','royal_tooltip_content','royal_tooltip_position',
                              'royal_tooltip_arrow','royal_tooltip_duration','royal_tooltip_size','royal_tooltip_animation'];
        if (style_controls.indexOf(e) === -1) return;

        var s = this.getRoyalSettings();
        if (s && s.enable) {
          this.$element.addClass('royal-tooltip-enable');
          if (this.getSpan().length === 0) {
            this.$element.append("<span class='royal-tooltip-content'></span>");
          }
          this.run(s);
        } else {
          this.$element.removeClass('royal-tooltip-enable');
          this.getSpan().remove();
        }
      },

      run: function run(s) {
        s = s || this.getRoyalSettings();
        if (!s || !s.enable) return;

        var content = this.getSpan();
        if (content.length === 0) return;

        content.html($.parseHTML(s.content || 'I am a tooltip'));
        content.css('animation-duration', (s.duration || 1000) + 'ms');
        if (s.animation) content.addClass(s.animation);
        
        if (s.arrow === 'false' || s.arrow === false || s.arrow === '') {
          content.addClass('no-arrow');
        } else {
          content.removeClass('no-arrow');
        }

        this.$element.off('click.royaltooltip mouseenter.royaltooltip mouseleave.royaltooltip');

        if (s.trigger === 'click') {
          this.$element.on('click.royaltooltip', function() { content.toggleClass('show'); });
        } else {
          this.$element.on('mouseenter.royaltooltip', function() { content.addClass('show'); });
          this.$element.on('mouseleave.royaltooltip', function() { content.removeClass('show'); });
        }
      }
    });

    var allTypes = ['widget', 'column', 'section', 'container'].concat(atomicTypes);
    $.each(allTypes, function (i, type) {
      elementorFrontend.hooks.addAction('frontend/element_ready/' + type, function ($scope) {
        elementorFrontend.elementsHandler.addHandler(AdvancedTooltip, { $element: $scope });
      });
    });
  });
})(jQuery);