/**
 * Social Share Functionality
 * Handles social media sharing and copy to clipboard features
 */

class SocialShare {
    constructor() {
        this.currentUrl = window.location.href;
        this.currentTitle = document.title;
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.setupShareUrls();
    }

    setupEventListeners() {
        // Copy to clipboard button
        const copyBtn = document.querySelector('.social-share .btn[onclick*="copyToClipboard"]');
        if (copyBtn) {
            copyBtn.addEventListener('click', (e) => {
                e.preventDefault();
                this.copyToClipboard();
            });
        }

        // Social share buttons tracking
        const socialButtons = document.querySelectorAll('.social-share a[onclick]');
        socialButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                const platform = this.getPlatformFromButton(button);
                this.trackShare(platform);
            });
        });
    }

    setupShareUrls() {
        // Update share URLs with current page data
        const shareData = {
            url: this.currentUrl,
            title: this.currentTitle,
            description: this.getMetaDescription()
        };

        // Facebook
        const facebookBtn = document.querySelector('.social-share a[title*="Facebook"]');
        if (facebookBtn) {
            facebookBtn.href = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(shareData.url)}&quote=${encodeURIComponent(shareData.title)}`;
        }

        // Twitter
        const twitterBtn = document.querySelector('.social-share a[title*="Twitter"]');
        if (twitterBtn) {
            twitterBtn.href = `https://twitter.com/intent/tweet?text=${encodeURIComponent(shareData.title)}&url=${encodeURIComponent(shareData.url)}`;
        }

        // LinkedIn
        const linkedinBtn = document.querySelector('.social-share a[title*="LinkedIn"]');
        if (linkedinBtn) {
            linkedinBtn.href = `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(shareData.url)}`;
        }

        // Zalo
        const zaloBtn = document.querySelector('.social-share a[title*="Zalo"]');
        if (zaloBtn) {
            zaloBtn.href = `https://zalo.me/share?u=${encodeURIComponent(shareData.url)}&t=${encodeURIComponent(shareData.title)}`;
        }
    }

    getMetaDescription() {
        const metaDesc = document.querySelector('meta[name="description"]');
        return metaDesc ? metaDesc.getAttribute('content') : '';
    }

    getPlatformFromButton(button) {
        const title = button.title.toLowerCase();
        if (title.includes('facebook')) return 'facebook';
        if (title.includes('twitter')) return 'twitter';
        if (title.includes('linkedin')) return 'linkedin';
        if (title.includes('zalo')) return 'zalo';
        return 'unknown';
    }

    async copyToClipboard() {
        try {
            if (navigator.clipboard && window.isSecureContext) {
                await navigator.clipboard.writeText(this.currentUrl);
                this.showNotification('Đã sao chép liên kết vào clipboard!', 'success');
            } else {
                this.fallbackCopyTextToClipboard(this.currentUrl);
            }
        } catch (err) {
            console.error('Failed to copy: ', err);
            this.fallbackCopyTextToClipboard(this.currentUrl);
        }
    }

    fallbackCopyTextToClipboard(text) {
        const textArea = document.createElement("textarea");
        textArea.value = text;
        textArea.style.top = "0";
        textArea.style.left = "0";
        textArea.style.position = "fixed";
        textArea.style.opacity = "0";
        
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        
        try {
            const successful = document.execCommand('copy');
            if (successful) {
                this.showNotification('Đã sao chép liên kết vào clipboard!', 'success');
            } else {
                this.showNotification('Không thể sao chép liên kết', 'error');
            }
        } catch (err) {
            this.showNotification('Không thể sao chép liên kết', 'error');
        }
        
        document.body.removeChild(textArea);
    }

    showNotification(message, type) {
        // Remove existing notification if any
        const existingNotification = document.querySelector('.copy-notification');
        if (existingNotification) {
            existingNotification.remove();
        }

        // Create notification element
        const notification = document.createElement('div');
        notification.className = `copy-notification alert alert-${type === 'success' ? 'success' : 'danger'} position-fixed`;
        notification.style.cssText = `
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            border: none;
            border-radius: 8px;
        `;
        notification.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="bi bi-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
                <span>${message}</span>
                <button type="button" class="btn-close ms-auto" onclick="this.parentElement.parentElement.remove()"></button>
            </div>
        `;

        // Add to page
        document.body.appendChild(notification);

        // Auto remove after 3 seconds
        setTimeout(() => {
            if (notification.parentElement) {
                notification.remove();
            }
        }, 3000);
    }

    trackShare(platform) {
        // Log share event
        console.log(`Shared on ${platform}: ${this.currentUrl}`);
        
        // Send to Google Analytics if available
        if (typeof gtag !== 'undefined') {
            gtag('event', 'share', {
                method: platform,
                content_type: 'article',
                item_id: this.getArticleId()
            });
        }

        // Send to Facebook Pixel if available
        if (typeof fbq !== 'undefined') {
            fbq('track', 'Share', {
                content_type: 'article',
                content_id: this.getArticleId()
            });
        }
    }

    getArticleId() {
        // Try to get article ID from various sources
        const articleElement = document.querySelector('article');
        if (articleElement && articleElement.id) {
            return articleElement.id.replace('post-', '');
        }
        
        // Fallback to URL slug
        const urlParts = this.currentUrl.split('/');
        return urlParts[urlParts.length - 1] || 'unknown';
    }
}

// Initialize social share functionality when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    new SocialShare();
});

// Export for use in other scripts
if (typeof module !== 'undefined' && module.exports) {
    module.exports = SocialShare;
} 