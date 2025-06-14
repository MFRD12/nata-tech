        const loading = document.getElementById('loading');
        const page = document.getElementById('page');
        let fakeProgress = 0;
        let realProgress = 0;
        let timer;
        let isNavigating = false;

        function startLoading(url) {
            fakeProgress = 0;
            realProgress = 0;
            isNavigating = true;
            page.classList.add('page-loading');

            // Fake smooth animation
            timer = setInterval(() => {
                if (fakeProgress < 85) {
                    fakeProgress += Math.random() * 15 + 5;
                    // Use the higher progress between fake and real
                    const currentProgress = Math.max(fakeProgress, realProgress);
                    loading.style.width = currentProgress + '%';
                }
            }, 80);

            // Navigate to URL
            setTimeout(() => {
                window.location.href = url;
            }, 150);
        }

        // Real progress tracking
        document.addEventListener('readystatechange', () => {
            if (isNavigating) {
                if (document.readyState === 'loading') {
                    realProgress = 20;
                } else if (document.readyState === 'interactive') {
                    realProgress = 70;
                } else if (document.readyState === 'complete') {
                    realProgress = 100;
                    completeLoading();
                }

                // Update progress bar with the higher value
                const currentProgress = Math.max(fakeProgress, realProgress);
                loading.style.width = currentProgress + '%';
            }
        });

        function completeLoading() {
            clearInterval(timer);
            loading.style.width = '100%';

            setTimeout(() => {
                loading.style.width = '0%';
                page.classList.remove('page-loading');
                isNavigating = false;
            }, 200);
        }

        // Handle link clicks
        document.addEventListener('click', e => {
            const link = e.target.closest('a');
            if (link?.href && !link.href.includes('#') && link.hostname === location.hostname) {
                e.preventDefault();
                startLoading(link.href);
            }
        });

        // Handle page load
        window.addEventListener('load', () => {
            if (!isNavigating) {
                loading.style.width = '0%';
                page.classList.remove('page-loading');
            }
        });