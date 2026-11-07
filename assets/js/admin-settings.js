// assets/js/admin-settings.js
jQuery(document).ready(function($) {

    // Tab switching code
    $('.royalsettingstabs .tabs li a').on('click', function(e) {
        if ($(this).attr('target') === '_blank') return; // Skip external links
        
        e.preventDefault();
        var target = $(this).attr('href');
        if ($(target).length) {
            $('.royalsettingstabs .tabs li').removeClass('active');
            $(this).parent().addClass('active');
            $('.tabcontent').hide();
            $(target).fadeIn(200);
            
            // Optionally update URL hash without jumping
            if (history.pushState) {
                history.pushState(null, null, target);
            } else {
                window.location.hash = target;
            }
        }
    });

    // Handle hash on load
    if (window.location.hash) {
        var hash = window.location.hash;
        if ($(hash).length && $('.royalsettingstabs .tabs li a[href="' + hash + '"]').length) {
            $('.royalsettingstabs .tabs li').removeClass('active');
            $('.royalsettingstabs .tabs li a[href="' + hash + '"]').parent().addClass('active');
            $('.tabcontent').hide();
            $(hash).show();
        }
    }

    // Save license key via AJAX
    const saveLicenseBtn = document.getElementById('save_license');
    if (saveLicenseBtn) {
        saveLicenseBtn.addEventListener('click', function () {
            const licenseKey = document.getElementById('license_key').value.trim();
            const licenseStatusDiv = document.getElementById('license_status');
            const messageDiv = document.getElementById('license_message');

            Swal.fire({
                title: 'Saving License...',
                text: 'Please wait...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            fetch(royalAdminSettings.ajaxurl, { // <-- ajaxurl from wp_localize_script
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8'
                },
                body: new URLSearchParams({
                    action: 'royal_save_license',
                    license_key: licenseKey,
                    _ajax_nonce: royalAdminSettings.license_nonce // <-- nonce from wp_localize_script
                })
            }).then(res => res.json())
                .then(data => {
                    Swal.close();

                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: data.data || 'License is valid.', // show server response message
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true
                        }).then(() => {
                            window.location.reload();
                        });
                        if (licenseStatusDiv) {
                            licenseStatusDiv.style.color = 'green';
                            licenseStatusDiv.textContent = 'License is valid.';
                        }
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: data.data || 'License is invalid!', // show server response message
                            confirmButtonText: 'OK'
                        });
                        if (licenseStatusDiv) {
                            licenseStatusDiv.style.color = 'red';
                            licenseStatusDiv.innerHTML = '<strong>' + (data.data || 'License is invalid!') + '</strong>';
                        }
                    }
                    messageDiv.style.color = data.success ? 'green' : 'red';
                    messageDiv.textContent = data.data || '';
                    setTimeout(() => { messageDiv.textContent = ''; }, 3000);
                }).catch(error => {
                    Swal.close();
                    console.error('Fetch error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Request Failed',
                        text: 'An unexpected error occurred: ' + error.message,
                        confirmButtonText: 'OK'
                    });
                });
        });
    }

    // Save Tweak Settings via AJAX
    const saveTweakBtn = document.getElementById('save_tweak_settings');
    if (saveTweakBtn) {
        saveTweakBtn.addEventListener('click', function () {
            const tweakSettingsData = new URLSearchParams();

            // Collect all checkbox values - ENSURE THIS LOOP IS WORKING
            document.querySelectorAll('.royal-tweak-options input[type="checkbox"]').forEach(checkbox => {
                if (checkbox.checked) {
                    tweakSettingsData.append(checkbox.name, checkbox.value);
                }
            });

            // Add action and nonce
            tweakSettingsData.append('action', 'royal_save_tweak_settings');
            tweakSettingsData.append('_ajax_nonce', royalAdminSettings.tweak_nonce);

            const tweakMessageDiv = document.getElementById('tweak_message');

            Swal.fire({
                title: 'Saving Settings...',
                text: 'Please wait...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            fetch(royalAdminSettings.ajaxurl, { // <-- ajaxurl from wp_localize_script
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8'
                },
                body: tweakSettingsData
            }).then(res => res.json())
                .then(data => {
                    Swal.close();

                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: data.data || 'Tweak settings saved successfully!', // show server response message
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: data.data || 'Failed to save tweak settings.', // show server response message
                            confirmButtonText: 'OK'
                        });
                    }
                    tweakMessageDiv.style.color = data.success ? 'green' : 'red';
                    tweakMessageDiv.textContent = data.data || '';
                    setTimeout(() => { tweakMessageDiv.textContent = ''; }, 3000);
                }).catch(error => {
                    Swal.close();
                    console.error('Fetch error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Request Failed',
                        text: 'An unexpected error occurred: ' + error.message,
                        confirmButtonText: 'OK'
                    });
                });
        });
    }


    // Enable/Disable All Buttons
    document.querySelectorAll('.royal-enable-all').forEach(btn => {
        btn.addEventListener('click', function() {
            const targetClass = this.getAttribute('data-target');
            document.querySelectorAll(targetClass).forEach(checkbox => checkbox.checked = true);
        });
    });

    document.querySelectorAll('.royal-disable-all').forEach(btn => {
        btn.addEventListener('click', function() {
            const targetClass = this.getAttribute('data-target');
            document.querySelectorAll(targetClass).forEach(checkbox => checkbox.checked = false);
        });
    });

    // Save Widgets Settings
    $('.save_widgets_trigger, #save_widgets_settings').on('click', function(e) {
        e.preventDefault();
        saveWidgetSettings(this);
    });

    function saveWidgetSettings(btn) {
        Swal.fire({
            title: 'Saving Widgets...',
            text: 'Please wait...',
            allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); }
        });

        const formData = new URLSearchParams();
        formData.append('action', 'royal_save_widgets');
        
        $('.royal-widget-free-toggle, .royal-widget-pro-toggle').each(function() {
            const key = $(this).attr('data-key');
            if (key) {
                formData.append('widgets[' + key + ']', $(this).is(':checked') ? 0 : 1);
            }
        });

        fetch(royalAdminSettings.ajaxurl, {
            method: 'POST',
            body: formData
        }).then(res => res.json())
        .then(data => {
            if (data.success) {
                Swal.fire({ icon: 'success', title: 'Saved!', text: data.data || 'Widgets updated successfully.', timer: 2000, showConfirmButton: false });
            } else {
                Swal.fire({ icon: 'error', title: 'Error!', text: data.data || 'Failed to save widgets.' });
            }
        }).catch(err => {
            Swal.fire({ icon: 'error', title: 'Request Failed', text: err.message });
        });
    }

    // Save Extensions Settings
    $('.save_extentions_trigger').on('click', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Saving Extensions...',
            text: 'Please wait...',
            allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); }
        });

        const formData = new URLSearchParams();
        formData.append('action', 'royal_save_extensions');
        
        $('.royal-ext-toggle').each(function() {
            const key = $(this).attr('data-key');
            if (key) {
                formData.append('extensions[' + key + ']', $(this).is(':checked') ? 0 : 1);
            }
        });

        fetch(royalAdminSettings.ajaxurl, {
            method: 'POST',
            body: formData
        }).then(res => res.json())
        .then(data => {
            if (data.success) {
                Swal.fire({ icon: 'success', title: 'Saved!', text: data.data || 'Extensions updated successfully.', timer: 2000, showConfirmButton: false });
            } else {
                Swal.fire({ icon: 'error', title: 'Error!', text: data.data || 'Failed to save extensions.' });
            }
        }).catch(err => {
            Swal.fire({ icon: 'error', title: 'Request Failed', text: err.message });
        });
    });
});