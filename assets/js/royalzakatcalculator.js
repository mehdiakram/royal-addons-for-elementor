(function($) {
    class RoyalZakatCalculatorHandler extends elementorModules.frontend.handlers.Base {
        
        onInit() {
            this.settings = this.$element.find('.royal-zakat-calculator-wrapper').data('settings');
            this.$elements = {};
            this.ZAKAT_RATE = 0.025;
            this.userOverwroteGoldValue = false;
            this.userOverwroteSilverValue = false;

            this.findElement();
            this.prefillFields();
            this.bindEvents();
            this.calculateZakat();
            
            super.onInit();
        }

        findElement() {
            const wrapper = this.$element.find('.royal-zakat-calculator-wrapper');
            this.$elements = {
                wrapper: wrapper,
                calculableInputs: wrapper.find('input[type="number"]'),
                clearableInputs: wrapper.find('input[type="number"]'),
                clearButton: wrapper.find('#rzc-clear-btn'),
                printButton: wrapper.find('#rzc-print-btn'),
                nisabValue: wrapper.find('#rzc-nisab-value'),
                goldGrams: wrapper.find('#rzc-gold-grams'),
                goldPrice: wrapper.find('#rzc-gold-price'),
                goldValue: wrapper.find('#rzc-gold-value'),
                silverGrams: wrapper.find('#rzc-silver-grams'),
                silverPrice: wrapper.find('#rzc-silver-price'),
                silverValue: wrapper.find('#rzc-silver-value'),
                cash: wrapper.find('#rzc-cash'),
                hajjDeposit: wrapper.find('#rzc-hajj-deposit'),
                loansGiven: wrapper.find('#rzc-loans-given'),
                investments: wrapper.find('#rzc-investments'),
                stockValue: wrapper.find('#rzc-stock-value'),
                borrowedMoney: wrapper.find('#rzc-borrowed-money'),
                wagesDue: wrapper.find('#rzc-wages-due'),
                billsDue: wrapper.find('#rzc-bills-due'),
                totalAssets: wrapper.find('#rzc-total-assets'),
                totalLiabilities: wrapper.find('#rzc-total-liabilities'),
                netWorth: wrapper.find('#rzc-net-worth'),
                zakatDue: wrapper.find('#rzc-zakat-due'),
				message: wrapper.find('#rzc-message'),
            };
        }

        bindEvents() {
            this.$elements.calculableInputs.on('input', (e) => this.calculateZakat(e.currentTarget));
            this.$elements.clearButton.on('click', () => this.clearForm());
            this.$elements.printButton.on('click', () => this.printReport());

            this.$elements.goldValue.on('input', () => { this.userOverwroteGoldValue = true; });
            this.$elements.silverValue.on('input', () => { this.userOverwroteSilverValue = true; });
        }

        printReport() {
            const today = new Date();
            const options = {
                weekday: 'long', year: 'numeric', month: 'long', day: 'numeric',
                hour: 'numeric', minute: 'numeric', hour12: true, timeZone: 'Asia/Dhaka'
            };
            const formattedDate = today.toLocaleString('en-US', options).replace(/, /g, ' | ');
            const printTitle = `Zakat Calculation Summary - ${formattedDate} (Bangladesh Standard Time)`;

            this.$elements.wrapper.attr('data-print-date', printTitle);

            setTimeout(() => {
                window.print();
                this.$elements.wrapper.removeAttr('data-print-date');
            }, 50); 
        }

        prefillFields() {
            const nisab = parseFloat(this.settings.nisab_value);
            const goldPrice = parseFloat(this.settings.gold_price);
            const silverPrice = parseFloat(this.settings.silver_price);

            this.$elements.nisabValue?.val(isNaN(nisab) ? '0.00' : nisab.toFixed(2));
            this.$elements.goldPrice?.val(isNaN(goldPrice) ? '0.00' : goldPrice.toFixed(2));
            this.$elements.silverPrice?.val(isNaN(silverPrice) ? '0.00' : silverPrice.toFixed(2));
        }

        clearForm() {
            this.$elements.clearableInputs.val('');
            this.userOverwroteGoldValue = false;
            this.userOverwroteSilverValue = false;
            this.prefillFields();
            this.calculateZakat();
        }
        
        calculateZakat(target) {
            const $target = $(target);
            const goldGrams = parseFloat(this.$elements.goldGrams?.val()) || 0;
            const goldPrice = parseFloat(this.$elements.goldPrice?.val()) || 0;
            const silverGrams = parseFloat(this.$elements.silverGrams?.val()) || 0;
            const silverPrice = parseFloat(this.$elements.silverPrice?.val()) || 0;
            
            if ($target.is(this.$elements.goldGrams) || $target.is(this.$elements.goldPrice)) {
                this.userOverwroteGoldValue = false;
            }
            if ($target.is(this.$elements.silverGrams) || $target.is(this.$elements.silverPrice)) {
                this.userOverwroteSilverValue = false;
            }
            
            let goldValue = this.userOverwroteGoldValue ? (parseFloat(this.$elements.goldValue?.val()) || 0) : goldGrams * goldPrice;
            let silverValue = this.userOverwroteSilverValue ? (parseFloat(this.$elements.silverValue?.val()) || 0) : silverGrams * silverPrice;

            if (!this.userOverwroteGoldValue) this.$elements.goldValue.val(goldValue.toFixed(2));
            if (!this.userOverwroteSilverValue) this.$elements.silverValue.val(silverValue.toFixed(2));
            
            const totalAssets = goldValue + silverValue +
                (parseFloat(this.$elements.cash?.val()) || 0) +
                (parseFloat(this.$elements.hajjDeposit?.val()) || 0) +
                (parseFloat(this.$elements.loansGiven?.val()) || 0) +
                (parseFloat(this.$elements.investments?.val()) || 0) +
                (parseFloat(this.$elements.stockValue?.val()) || 0);
            
            this.$elements.totalAssets?.text(this.formatCurrency(totalAssets));

            const totalLiabilities = 
                (parseFloat(this.$elements.borrowedMoney?.val()) || 0) +
                (parseFloat(this.$elements.wagesDue?.val()) || 0) +
                (parseFloat(this.$elements.billsDue?.val()) || 0);

            this.$elements.totalLiabilities?.text(this.formatCurrency(totalLiabilities));

            const netWorth = totalAssets - totalLiabilities;
            this.$elements.netWorth?.text(this.formatCurrency(netWorth));
            
            const nisab = parseFloat(this.$elements.nisabValue?.val()) || 0;

            if (netWorth >= nisab) {
                const zakatAmount = netWorth * this.ZAKAT_RATE;
                this.$elements.zakatDue?.text(this.formatCurrency(zakatAmount));
				this.$elements.message?.text(this.settings.msg_above_nisab).removeClass('nisab-not-met').addClass('nisab-met');
            } else {
                this.$elements.zakatDue?.text(this.formatCurrency(0));
                this.$elements.message?.text(this.settings.msg_below_nisab).removeClass('nisab-met').addClass('nisab-not-met');
            }
        }

        formatCurrency(amount) {
            const symbol = this.settings.currency_symbol || '';
            const num = Number(amount);
            if (isNaN(num)) return symbol + ' 0.00';
            const fixedAmount = num.toFixed(2);
            let parts = fixedAmount.split('.');
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            return symbol + ' ' + parts.join('.');
        }
    }

    $(window).on('elementor/frontend/init', () => {
        elementorFrontend.hooks.addAction('frontend/element_ready/royalzakatcalculator.default', ($element) => {
            new RoyalZakatCalculatorHandler({ $element });
        });
    });

})(jQuery);
