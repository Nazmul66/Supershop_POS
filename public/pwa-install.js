
    if ('serviceWorker' in navigator && 'BeforeInstallPromptEvent' in window) {
    // Listen for the beforeinstallprompt event
    window.addEventListener('beforeinstallprompt', (event) => {
        // Prevent the default "Add to Home Screen" prompt
        event.preventDefault();

        window.addEventListener('DOMContentLoaded', () => {
            let displayMode = 'browser tab';
            if (window.matchMedia('(display-mode: standalone)').matches) {
                displayMode = 'standalone';
            }
            // Log launch display mode to analytics
            console.log('DISPLAY_MODE_LAUNCH:', displayMode);
        });

        // Show the "Install App" button
        let installButton = document.getElementById('appInstallModal');
        let closeInstallModal = document.getElementById('closeInstallModal');
        let pwaInstallModal;
        if (installButton) {
            pwaInstallModal = new bootstrap.Modal(installButton, {
                keyboard: true,
                backdrop: true,
            });

            pwaInstallModal.show();

            if (closeInstallModal) {
                closeInstallModal.addEventListener('click', () => {
                    pwaInstallModal.hide();
                });
            }
        }

        const installPwa = document.getElementById('installPwa');

        if (installPwa) {
            installPwa.addEventListener('click', () => {
                pwaInstallModal.hide();
            });
        }

        // Save the event for later use
        let deferredPrompt = event;

        // Add event listener to the "Install App" button
        installPwa.addEventListener('click', () => {
            // Trigger the "Add to Home Screen" prompt
            deferredPrompt.prompt();

            // Wait for the user to respond to the prompt
            deferredPrompt.userChoice
                .then((choiceResult) => {
                    // Reset the prompt variable
                    deferredPrompt = null;
                    // Hide the "Install App" button after the prompt is shown
                    pwaInstallModal.hide();
                });
        });
    });
}



// let deferredPrompt;

// window.addEventListener('beforeinstallprompt', (e) => {
//     e.preventDefault();
//     deferredPrompt = e;

//     const installBtn = document.getElementById('pwa-install-btn');
//     if (installBtn) {
//         installBtn.style.display = 'block';
//     }
// });

// document.addEventListener('DOMContentLoaded', () => {
//     const installBtn = document.getElementById('pwa-install-btn');

//     if (installBtn) {
//         installBtn.addEventListener('click', async () => {
//             if (!deferredPrompt) return;

//             deferredPrompt.prompt();
//             const { outcome } = await deferredPrompt.userChoice;

//             console.log(`User response to the install prompt: ${outcome}`);

//             installBtn.style.display = 'none';
//             deferredPrompt = null;
//         });
//     }
// });

// window.addEventListener('appinstalled', () => {
//     console.log('PWA was installed');
//     // your logic to handle the PWA installation
// });
