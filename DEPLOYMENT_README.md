# Public Matters Lebanon - Deployment Package

## 📦 Package Information

**File:** publicmatterslebanon-deployment.zip  
**Size:** 13.07 MB  
**Files:** 195 total files  
**Ready For:** Namecheap cPanel Hosting

---

## 🚀 Deployment Steps

### 1. Login to Namecheap cPanel
- Go to your Namecheap account
- Navigate to hosting dashboard
- Click "cPanel" for your domain

### 2. Upload the ZIP File
- In cPanel, open **File Manager**
- Navigate to `public_html` folder
- Click **Upload** button
- Select `publicmatterslebanon-deployment.zip`
- Wait for upload to complete (13.07 MB)

### 3. Extract the ZIP File
- Return to File Manager
- Find the uploaded ZIP file in `public_html`
- **Right-click** on the ZIP file
- Select **Extract**
- Choose `public_html` as extraction destination
- Click **Extract Files** button

### 4. Clean Up
- After successful extraction, **delete the ZIP file**
- This saves server space
- Verify all files extracted properly

### 5. Configure Email (IMPORTANT!)
- In cPanel, go to **Email Accounts**
- Create new email: `noreply@publicmatterslebanon.org`
- Set a secure password
- This email is required for the contact form to work

### 6. Verify SSL Certificate
- In cPanel, go to **SSL/TLS Status**
- Enable **AutoSSL** if not already enabled
- Wait for certificate to be issued (usually automatic)
- May take a few minutes

### 7. Test the Website
- Visit: `https://publicmatterslebanon.org`
- Test all navigation links
- Test contact form submission
- Verify images load correctly
- Check SSL padlock in browser

---

## 📋 Package Contents

### HTML Pages (12 files)
- ✅ index.html - Landing page
- ✅ main.html - Main content page
- ✅ journey.html - Journey section
- ✅ mission.html - Mission section
- ✅ founder.html - Founder section
- ✅ involvement.html - Involvement section
- ✅ awareness.html - Awareness section
- ✅ engagement.html - Engagement section
- ✅ sustainability.html - Sustainability section
- ✅ press.html - Press section
- ✅ contact-us.html - Contact form
- ✅ karkha.html - Karkha section

### Images (168 files, 12.33 MB)
- All images downloaded locally
- Original high quality preserved
- No external CDN dependencies

### Backend Files
- ✅ **send_email.php** - Contact form email handler
- ✅ **.htaccess** - Apache configuration

---

## 📧 Contact Form Configuration

**Recipient Email:** julie.bouchakra@publicmatterslebanon.org  
**From Email:** noreply@publicmatterslebanon.org  
**Handler Script:** send_email.php  
**Method:** AJAX POST request

### Form Fields:
- Name (required)
- Email (required)
- Message (required)

### Success Message:
"Thank you for the time submitting your message!"

---

## ⚙️ .htaccess Features

### SSL/HTTPS
- ✅ Automatic HTTPS redirect
- ✅ Forces secure connections

### Clean URLs
- ✅ Removes .html extension from URLs
- ✅ `/main` instead of `/main.html`
- ✅ SEO-friendly URLs

### Security Headers
- ✅ X-Frame-Options (prevents clickjacking)
- ✅ X-XSS-Protection (XSS protection)
- ✅ X-Content-Type-Options (MIME sniffing prevention)
- ✅ Referrer-Policy (referrer control)

### Performance
- ✅ GZIP compression enabled
- ✅ Browser caching configured
- ✅ 1 year cache for images
- ✅ 1 month cache for CSS/JS

### Error Handling
- ✅ Custom 404 redirects to index.html
- ✅ Custom 500 redirects to index.html
- ✅ Directory browsing disabled

---

## 🔧 Technical Details

### Server Requirements
- **PHP:** 7.0 or higher
- **Apache:** mod_rewrite enabled
- **Mail Function:** PHP mail() enabled
- **SSL:** AutoSSL or custom certificate

### Email Configuration
The contact form uses PHP's native `mail()` function. For Namecheap hosting, this works automatically once you create the `noreply@publicmatterslebanon.org` email account.

### URL Structure
```
https://publicmatterslebanon.org/           → index.html (landing)
https://publicmatterslebanon.org/main       → main.html
https://publicmatterslebanon.org/journey    → journey.html
https://publicmatterslebanon.org/contact-us → contact-us.html
```

---

## ✅ Post-Deployment Checklist

- [ ] ZIP file uploaded to public_html
- [ ] Files extracted successfully
- [ ] ZIP file deleted
- [ ] Email account created: noreply@publicmatterslebanon.org
- [ ] SSL certificate active (green padlock)
- [ ] Website loads: https://publicmatterslebanon.org
- [ ] All pages accessible
- [ ] Images load correctly
- [ ] Contact form submits successfully
- [ ] Email received at julie.bouchakra@publicmatterslebanon.org

---

## 🐛 Troubleshooting

### Contact Form Not Sending Emails
1. Verify `noreply@publicmatterslebanon.org` email exists in cPanel
2. Check PHP mail() function is enabled (contact Namecheap support)
3. Check spam folder for test emails
4. Verify recipient email: julie.bouchakra@publicmatterslebanon.org

### Images Not Loading
1. Verify all files extracted from ZIP
2. Check `images` folder exists in public_html
3. Verify file permissions (should be 644 for files, 755 for folders)
4. Clear browser cache and reload

### SSL Certificate Issues
1. Wait 10-15 minutes for AutoSSL to issue certificate
2. In cPanel > SSL/TLS Status, click "Run AutoSSL"
3. Contact Namecheap support if issues persist

### 404 Errors on Pages
1. Verify .htaccess file exists in public_html
2. Check mod_rewrite is enabled (usually enabled by default)
3. Verify all HTML files are in public_html root, not subfolder

---

## 📞 Support

**Website:** https://publicmatterslebanon.org  
**Contact Email:** julie.bouchakra@publicmatterslebanon.org  
**Hosting:** Namecheap cPanel  

---

## 📝 Notes

- All images are hosted locally (no external dependencies)
- Google Analytics tracking ID: G-HQJZK784L8
- Facebook Pixel ID: 1262170797801870 (via Google Tag Manager)
- Google Tag Manager ID: GTM-KS96D35
- All external tracking scripts remain active

---

**Package Created:** February 7, 2026  
**Version:** 1.0  
**Status:** Ready for Production Deployment ✅
