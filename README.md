# Public Matters Lebanon - Subproject Workflow

**Domain:** www.publicmatterslebanon.org  
**Contact:** info@publicmatterslebanon.org  
**Status:** ⏳ In Progress  
**Workspace:** `c:\Users\Alaa\Documents\githup\Selenium\publicmatterslebanon\`

---

## Project Context

This is **subproject #11** of an 11-website migration project. Each domain gets its own isolated folder within the Selenium workspace.

**Parent Project:** Selenium Website Migration  
**Guide Location:** `../PROJECT_WORKFLOW_GUIDE.md`

---

## Workflow Stages (Apply from Parent Guide)

### Stage 1: Project Initialization ✅
- Folder created: `publicmatterslebanon/`
- Location verified in Selenium workspace

### Stage 2: Source Code Import
- Obtain HTML from www.publicmatterslebanon.org
- Create `index.html` or check if already in `dist/index.html`
- **Current:** Site has `dist/` folder structure (5128 lines)

### Stage 3: Initial Local Testing
- Run http-server or file:// protocol
- Open DevTools → Check Console/Network errors
- Document all 404s and external dependencies

### Stage 4: Asset Localization - Images
- Download images to `dist/images/`
- **Status:** 7 images downloaded (backgrounds/1.jpg, x_loader.gif, 5 tooltip icons)
- Create subdirectories: `backgrounds/`, `ui_icons/`

### Stage 5: Asset Localization - CSS/JS
- Download external CSS/JS to `dist/assets/`
- Check for fonts, libraries, frameworks

### Stage 6: Path Replacement
- Replace all CDN URLs with local paths
- **Fix Applied:** Changed 7 CSS `url()` paths from `/images/...` → `images/...`
- **Fix Applied:** Removed `/dist/` prefix from script/link tags

### Stage 7: JavaScript Localization
- Check for hardcoded CDN URLs in JS files
- Modify if necessary for local image references

### Stage 8: Special Fixes
- **Applied:** HTTPS redirect script commented out (lines 4693-4699)
- This prevented SSL errors on localhost

### 🔥 CRITICAL: Indigo Platform Multi-Page vbid CSS Fix

**⚠️ IF THIS IS A MULTI-PAGE INDIGO SITE, READ THIS! ⚠️**

**Problem:** If you see pages displaying in mobile/narrow view with oversized text while home page looks correct, you have a vbid CSS issue.

**Root Cause:** Indigo CMS generates unique CSS per page using different `vbid` (view-block-id) parameters. Each page needs its own CSS file.

**Solution:**
1. Extract vbid from each page's HTML (look for `data-root-id="vbid-xxxxx"`)
2. Download page-specific CSS for each vbid from Indigo server
3. Update each HTML to reference its specific CSS file

**NEVER use one shared static_style.css for all Indigo pages!**

**Full Implementation:** See mirsat README for complete step-by-step guide with PowerShell scripts.

---

### Stage 9: Backend Implementation
- **Contact Form Email Handler:** Create PHP backend to send form submissions via email
- **File:** `contact_handler.php` or similar
- **Required:** Configure SMTP or use PHP `mail()` function
- **Test:** Submit form and verify email delivery
- **Status:** Not started

### Stage 10: Final Testing
- Cross-browser testing (Chrome, Firefox, Safari, Edge)
- Responsive design validation (mobile, tablet, desktop)
- Form submissions and email delivery
- All navigation links working
- Image loading verification

### Stage 11: Deployment Package for Namecheap
- **Create .htaccess file** for URL routing and security
- **ZIP all files** for upload to Namecheap cPanel
- **Required files in ZIP:**
  - index.html
  - dist/ folder (or all assets)
  - .htaccess
  - contact_handler.php (if applicable)
  - Any other PHP files
- **Upload to:** Namecheap cPanel → File Manager → public_html/
- **Extract ZIP** on server
- **Test live URL** after deployment

---

## Current Project Structure

```
publicmatterslebanon/
├── README.md              # This file
├── dist/                  # Main serving directory
│   ├── index.html        # 5128 lines
│   ├── assets/
│   │   ├── css/
│   │   └── js/
│   └── images/
│       ├── backgrounds/
│       └── ui_icons/
```

---

## Known Issues & Fixes Applied

### Issue 1: Absolute Paths with /dist/ Prefix
**Problem:** Script/link tags had `/dist/` in paths  
**Fix:** Removed prefix via PowerShell replace  
**Status:** ✅ FIXED

### Issue 2: CSS url() Absolute Paths
**Problem:** 7 CSS background images used `/images/...`  
**Fix:** Changed to relative `images/...`  
**Locations:** Lines 110, 218, 234, 247, 251, 255, 259  
**Status:** ✅ FIXED

### Issue 3: Missing CSS Background Images
**Problem:** 7 images not in dist folder  
**Source:** Downloaded from http://www.indigo-cy.com  
**Files:**
- backgrounds/1.jpg
- x_loader.gif
- ui_icons/icon_* (5 tooltip icons)
**Status:** ✅ FIXED

### Issue 4: HTTPS Redirect Script
**Problem:** Script forced https:// on localhost causing SSL errors  
**Fix:** Commented out lines 4693-4699 in index.html  
**Status:** ✅ FIXED

---

## Critical Fixes Applied

### 🔥 CRITICAL: Image Quality - Always Use High Resolution

**⚠️ NEVER DOWNLOAD LOW-RESOLUTION IMAGES ⚠️**

**Rule:** Always download the highest quality/original images from the live site. Check image URLs for size parameters (s1600, s800, s400, w=800, h=600, etc.) and use the highest available size or remove size parameters entirely. Compare downloaded file sizes with live site images to ensure quality matches.

**Example:**
```powershell
# ❌ BAD - Downloads low-res version
Invoke-WebRequest "https://lh3.googleusercontent.com/image.jpg=s400"

# ✅ GOOD - Downloads high-res version
Invoke-WebRequest "https://lh3.googleusercontent.com/image.jpg=s1600"

# ✅ BETTER - Downloads original
Invoke-WebRequest "https://lh3.googleusercontent.com/image.jpg"
``` (February 1, 2026)

### SUCCESSFUL METHODS - Use These for Future Projects

#### Method 1: Removing /dist/ Prefix from Paths

**Problem:** Script/link tags had `/dist/` in paths causing 404 errors.

**Successful Fix:**
```powershell
$file = "dist\index.html"
(Get-Content $file -Raw) -replace 'src="/dist/', 'src="' -replace 'href="/dist/', 'href="' | Set-Content $file -NoNewline
```

**Key Lesson:** When serving from dist/ folder, all paths must be relative without leading `/dist/`.

---

#### Method 2: Fixing CSS url() Absolute Paths

**Problem:** 7 CSS background images used absolute paths `/images/...` causing 404 errors.

**Locations Fixed:**
- Line 110: `url(/images/backgrounds/1.jpg)` → `url(images/backgrounds/1.jpg)`
- Line 218: `url(/images/x_loader.gif)` → `url(images/x_loader.gif)`
- Lines 234, 247, 251, 255, 259: 5 tooltip icon paths fixed

**Successful Script:**
```powershell
$file = "dist\index.html"
$content = Get-Content $file -Raw
$content = $content -replace 'url\(/images/', 'url(images/'
Set-Content $file $content -NoNewline
```

**Key Lesson:** CSS url() paths must be relative when serving from subdirectories.

---

#### Method 3: Downloading Missing CSS Background Images

**Problem:** 7 images referenced in CSS but not in dist/images/ folder.

**Source:** Downloaded from http://www.indigo-cy.com

**Successful Download Script:**
```powershell
$images = @(
    @{Url="http://www.indigo-cy.com/images/backgrounds/1.jpg"; File="dist\images\backgrounds\1.jpg"},
    @{Url="http://www.indigo-cy.com/images/x_loader.gif"; File="dist\images\x_loader.gif"}
    # + 5 tooltip icons
)

foreach ($img in $images) {
    New-Item -ItemType Directory -Force -Path (Split-Path $img.File -Parent) | Out-Null
    Invoke-WebRequest -Uri $img.Url -OutFile $img.File -UseBasicParsing
    Write-Host "Downloaded: $(Split-Path $img.File -Leaf)"
}
```

**Files Downloaded:**
- backgrounds/1.jpg
- x_loader.gif
- ui_icons/icon_* (5 tooltip icons)

**Key Lesson:** Check CSS files for url() references, not just HTML image tags.

---

#### Method 4: Disabling HTTPS Redirect Script

**Problem:** HTTPS redirect script forced https:// on localhost causing SSL errors (ERR_SSL_PROTOCOL_ERROR).

**Location:** Lines 4693-4699 in dist/index.html

**Successful Fix:**
```html
<!-- User Head Code -->
<!-- HTTPS redirect disabled for localhost development -->
<!--
<script language="JavaScript">
if(window.location.protocol != 'https:')
{ location.href = location.href.replace("http://", "https://"); }
</script>
-->
```

**Key Lesson:** Always disable HTTPS redirects for local development. Re-enable before deployment.

---

#### Method 5: Using file:// Protocol for Testing

**Problem:** http-server kept stopping or refusing connections.

**Successful Alternative:**
```powershell
start chrome "file:///c:/Users/Alaa/Documents/githup/Selenium/publicmatterslebanon/dist/index.html"
```

**Key Lesson:** For static sites without server-side logic, file:// protocol works perfectly and avoids server issues.

---

### Local Testing Methods

**🔐 SSL Server (RECOMMENDED - No HTTPS redirect issues!):**

**Option 1: Quick Start**
```powershell
.\start.ps1
```

**Option 2: Universal Launcher**
```powershell
.\start_ssl_server.ps1 publicmatterslebanon 8080
```

**Option 3: Manual SSL Server**
```powershell
cd dist
http-server -S -C "C:\ssl\localhost+2.pem" -K "C:\ssl\localhost+2-key.pem" -p 8080
# Open: https://127.0.0.1:8080
```

**🛠️ SSL Setup (Already Done!)** - Certificates in C:\ssl\ valid until May 3, 2028

**📋 Stop Server:** `Get-Process node | Stop-Process`

**Alternative Methods (if SSL not needed):**
- **file:// Protocol:** `start chrome "file:///c:/Users/Alaa/Documents/githup/Selenium/publicmatterslebanon/dist/index.html"`
- **http-server:** `cd dist; http-server -p 8080`

**Important:** MUST cd into dist/ folder before starting server.

---

### Complete Project Realization Checklist

✅ **Stage 1-3: Initial Setup**
- Folder created: publicmatterslebanon/
- HTML source obtained (5128 lines)
- Initial testing identified issues

✅ **Stage 4: Image Localization**
- 7 CSS background images downloaded
- Subdirectories created (backgrounds/, ui_icons/)

✅ **Stage 5-6: CSS/JS Localization**
- All external assets already embedded
- Path corrections applied

✅ **Stage 7: JavaScript Fixes**
- No JavaScript modifications needed

✅ **Stage 8: Special Fixes**
- HTTPS redirect disabled (lines 4693-4699)
- All path prefixes corrected

⏳ **Stage 9: Backend Implementation**
- Contact form PHP handler needed
- Email functionality pending

⏳ **Stage 10: Final Testing**
- Cross-browser testing pending
- Form submission testing pending

⏳ **Stage 11: Deployment Package**
- Create .htaccess file
- Create deployment ZIP
- Push to GitHub repository

---

### Important Notes

- Website structure: Has dist/ folder - always serve from there
- All paths now relative and working
- HTTPS redirect commented out for local testing
- Re-enable HTTPS redirect before deployment
- **Deployment:** Create publicmatterslebanon_deployment.zip for Namecheap upload

---

## For New AI Conversations

**You are working on a subproject.** Read the parent guide first:
```
../PROJECT_WORKFLOW_GUIDE.md
```

**This README documents:**
- What has already been done
- Known issues and their fixes
- Current project structure
- Workflow stage progress

**Your job:**
- Continue from where previous work stopped
- Apply remaining workflow stages
- Test and validate the website locally (figure out the method yourself)
- Update this README with new progress

**DO NOT:**
- Re-download already downloaded images
- Re-apply already completed fixes
- Waste time on solved problems

---

## Useful Commands (From Parent Guide)

```powershell
# Navigate to this project
cd "c:\Users\Alaa\Documents\githup\Selenium\publicmatterslebanon"

# Check file sizes
Get-ChildItem -Recurse | Measure-Object -Property Length -Sum

# Search for patterns
Select-String -Path "dist\index.html" -Pattern "https://"

# Download single image
Invoke-WebRequest -Uri "URL" -OutFile "dist\images\filename.jpg"
```


---

## 🚀 Stage 11: Deployment Package - CRITICAL REQUIREMENTS

### ⚠️ BEFORE CREATING ZIP - CHECKLIST:

#### 1. **Email Backend Verification** (contact_handler.php)
```powershell
# MUST CHECK ORIGINAL SITE FOR EMAIL CONFIGURATION
# Go to: https://original-domain.com (inspect contact form submission)
# Find: Email recipient address in form action or backend

# Example: contact_handler.php should have:
$to = "info@client-domain.com";  // ← CHECK ORIGINAL SITE FOR THIS!
$subject = "Contact Form Submission from Website";
```

**Steps:**
1. Open original website in browser
2. Open DevTools → Network tab
3. Submit contact form
4. Check POST request for email destination
5. Update `contact_handler.php` with correct email address
6. Test locally before deploying

---

#### 2. **.htaccess Configuration** (Must be Namecheap-ready)
```apache
# filepath: .htaccess

# PRODUCTION CONFIGURATION FOR NAMECHEAP
# Force HTTPS (Namecheap provides SSL certificate)
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

# Remove .html extension from URLs
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^([^\.]+)$ ---

**Last Updated:.html [NC,L]

# Custom error pages (optional)
ErrorDocument 404 /404.html
ErrorDocument 500 /500.html

# Security headers
Header set X-Content-Type-Options "nosniff"
Header set X-Frame-Options "SAMEORIGIN"
Header set X-XSS-Protection "1; mode=block"

# Cache control for better performance
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType image/jpg "access plus 1 year"
    ExpiresByType image/jpeg "access plus 1 year"
    ExpiresByType image/gif "access plus 1 year"
    ExpiresByType image/png "access plus 1 year"
    ExpiresByType text/css "access plus 1 month"
    ExpiresByType application/javascript "access plus 1 month"
</IfModule>
```

**Important:** 
- ✅ Namecheap provides SSL certificate automatically
- ✅ Our local SSL (`C:\ssl\`) is ONLY for local testing
- ❌ Do NOT include local SSL certificates in deployment ZIP

---

#### 3. **HTTPS Redirect Scripts - RE-ENABLE FOR DEPLOYMENT**
```powershell
# If you disabled HTTPS redirect for local testing, RE-ENABLE IT NOW!

$files = @('index.html', 'about-us.html', 'services.html', 'contact.html')
foreach ($file in $files) {
    if (Test-Path $file) {
        $content = Get-Content $file -Raw -Encoding UTF8
        # Remove comment tags around HTTPS redirect script
        $content = $content -replace '<!-- DISABLED FOR LOCAL TESTING:\s*', ''
        $content = $content -replace '\s*-->\s*<!-- END DISABLED HTTPS REDIRECT -->', ''
        $content | Set-Content $file -Encoding UTF8 -NoNewline
        Write-Host "✅ Re-enabled HTTPS redirect in $file"
    }
}
```

---

#### 4. **Remove Local Testing Files from ZIP**
**DO NOT INCLUDE:**
- ❌ `start.ps1` (local SSL launcher)
- ❌ `start_ssl_server.ps1` (universal SSL launcher)
- ❌ Any `.ps1` PowerShell scripts
- ❌ `README.md` (optional - keep if useful for client)
- ❌ `.git/` folder (if present)

**MUST INCLUDE:**
- ✅ All HTML files
- ✅ `images/` folder
- ✅ `assets/` folder (css, js)
- ✅ `fonts/` folder (if applicable)
- ✅ `contact_handler.php` (with correct email)
- ✅ `.htaccess` (production-ready)

---

#### 5. **Create Deployment ZIP**
```powershell
# Navigate to project folder
cd "C:\Users\Alaa\Documents\githup\Selenium\<project-name>"

# Create ZIP excluding local testing files
$exclude = @('*.ps1', 'README.md', '.git')
$source = Get-ChildItem -Exclude $exclude
Compress-Archive -Path $source -DestinationPath "project_deployment.zip" -Force

Write-Host "✅ Deployment package created: project_deployment.zip"
Write-Host "📦 Ready for Namecheap upload!"
```

---

### 📋 Pre-Deployment Checklist

Before uploading to Namecheap, verify:

- [ ] **Email Backend**: `contact_handler.php` points to correct client email
- [ ] **HTTPS Redirects**: Re-enabled in all HTML files (if disabled for local testing)
- [ ] **Navigation Links**: Using relative paths (`about-us.html`, not `/about-us`)
- [ ] **.htaccess**: Production configuration (HTTPS redirect, clean URLs)
- [ ] **Tracking Scripts**: Re-enabled (Google Analytics, etc.)
- [ ] **Image Paths**: All using local paths (no CDN URLs)
- [ ] **CSS/JS Paths**: All using local paths (no CDN URLs)
- [ ] **No Local Testing Files**: Removed `.ps1` scripts from ZIP
- [ ] **Test ZIP Contents**: Extract and verify all files present

---

### 🎯 Namecheap Deployment Steps

1. **Login to Namecheap cPanel**
2. **Navigate to File Manager**
3. **Go to `public_html` directory**
4. **Delete existing files** (if replacing old site)
5. **Upload `project_deployment.zip`**
6. **Extract ZIP** (right-click → Extract)
7. **Delete ZIP file** after extraction
8. **Set file permissions** (if needed):
   - HTML files: 644
   - Folders: 755
   - PHP files: 644
9. **Test website**: Visit `https://yourdomain.com`
10. **Test contact form**: Submit and verify email received

---

### 🔒 SSL Certificate on Namecheap

- Namecheap provides **FREE SSL certificate** (Let's Encrypt)
- SSL activates automatically within 24 hours
- Our local SSL (`C:\ssl\`) is **ONLY for local testing**
- `.htaccess` HTTPS redirect will work once Namecheap SSL is active

---

### 📧 Email Configuration Notes

**Common Email Patterns:**
- `info@domain.com`
- `contact@domain.com`
- `admin@domain.com`
- `support@domain.com`

**How to Find:**
1. Check original site's contact form submission (DevTools → Network)
2. Ask client for their business email
3. Check domain's email hosting (Namecheap email, Gmail, etc.)

**Update in contact_handler.php:**
```php
$to = "info@client-domain.com";  // ← VERIFY THIS!
$from = # Public Matters Lebanon - Subproject Workflow

**Domain:** www.publicmatterslebanon.org  
**Contact:** info@publicmatterslebanon.org  
**Status:** ⏳ In Progress  
**Workspace:** `c:\Users\Alaa\Documents\githup\Selenium\publicmatterslebanon\`

---

## Project Context

This is **subproject #11** of an 11-website migration project. Each domain gets its own isolated folder within the Selenium workspace.

**Parent Project:** Selenium Website Migration  
**Guide Location:** `../PROJECT_WORKFLOW_GUIDE.md`

---

## Workflow Stages (Apply from Parent Guide)

### Stage 1: Project Initialization ✅
- Folder created: `publicmatterslebanon/`
- Location verified in Selenium workspace

### Stage 2: Source Code Import
- Obtain HTML from www.publicmatterslebanon.org
- Create `index.html` or check if already in `dist/index.html`
- **Current:** Site has `dist/` folder structure (5128 lines)

### Stage 3: Initial Local Testing
- Run http-server or file:// protocol
- Open DevTools → Check Console/Network errors
- Document all 404s and external dependencies

### Stage 4: Asset Localization - Images
- Download images to `dist/images/`
- **Status:** 7 images downloaded (backgrounds/1.jpg, x_loader.gif, 5 tooltip icons)
- Create subdirectories: `backgrounds/`, `ui_icons/`

### Stage 5: Asset Localization - CSS/JS
- Download external CSS/JS to `dist/assets/`
- Check for fonts, libraries, frameworks

### Stage 6: Path Replacement
- Replace all CDN URLs with local paths
- **Fix Applied:** Changed 7 CSS `url()` paths from `/images/...` → `images/...`
- **Fix Applied:** Removed `/dist/` prefix from script/link tags

### Stage 7: JavaScript Localization
- Check for hardcoded CDN URLs in JS files
- Modify if necessary for local image references

### Stage 8: Special Fixes
- **Applied:** HTTPS redirect script commented out (lines 4693-4699)
- This prevented SSL errors on localhost

### 🔥 CRITICAL: Indigo Platform Multi-Page vbid CSS Fix

**⚠️ IF THIS IS A MULTI-PAGE INDIGO SITE, READ THIS! ⚠️**

**Problem:** If you see pages displaying in mobile/narrow view with oversized text while home page looks correct, you have a vbid CSS issue.

**Root Cause:** Indigo CMS generates unique CSS per page using different `vbid` (view-block-id) parameters. Each page needs its own CSS file.

**Solution:**
1. Extract vbid from each page's HTML (look for `data-root-id="vbid-xxxxx"`)
2. Download page-specific CSS for each vbid from Indigo server
3. Update each HTML to reference its specific CSS file

**NEVER use one shared static_style.css for all Indigo pages!**

**Full Implementation:** See mirsat README for complete step-by-step guide with PowerShell scripts.

---

### Stage 9: Backend Implementation
- **Contact Form Email Handler:** Create PHP backend to send form submissions via email
- **File:** `contact_handler.php` or similar
- **Required:** Configure SMTP or use PHP `mail()` function
- **Test:** Submit form and verify email delivery
- **Status:** Not started

### Stage 10: Final Testing
- Cross-browser testing (Chrome, Firefox, Safari, Edge)
- Responsive design validation (mobile, tablet, desktop)
- Form submissions and email delivery
- All navigation links working
- Image loading verification

### Stage 11: Deployment Package for Namecheap
- **Create .htaccess file** for URL routing and security
- **ZIP all files** for upload to Namecheap cPanel
- **Required files in ZIP:**
  - index.html
  - dist/ folder (or all assets)
  - .htaccess
  - contact_handler.php (if applicable)
  - Any other PHP files
- **Upload to:** Namecheap cPanel → File Manager → public_html/
- **Extract ZIP** on server
- **Test live URL** after deployment

---

## Current Project Structure

```
publicmatterslebanon/
├── README.md              # This file
├── dist/                  # Main serving directory
│   ├── index.html        # 5128 lines
│   ├── assets/
│   │   ├── css/
│   │   └── js/
│   └── images/
│       ├── backgrounds/
│       └── ui_icons/
```

---

## Known Issues & Fixes Applied

### Issue 1: Absolute Paths with /dist/ Prefix
**Problem:** Script/link tags had `/dist/` in paths  
**Fix:** Removed prefix via PowerShell replace  
**Status:** ✅ FIXED

### Issue 2: CSS url() Absolute Paths
**Problem:** 7 CSS background images used `/images/...`  
**Fix:** Changed to relative `images/...`  
**Locations:** Lines 110, 218, 234, 247, 251, 255, 259  
**Status:** ✅ FIXED

### Issue 3: Missing CSS Background Images
**Problem:** 7 images not in dist folder  
**Source:** Downloaded from http://www.indigo-cy.com  
**Files:**
- backgrounds/1.jpg
- x_loader.gif
- ui_icons/icon_* (5 tooltip icons)
**Status:** ✅ FIXED

### Issue 4: HTTPS Redirect Script
**Problem:** Script forced https:// on localhost causing SSL errors  
**Fix:** Commented out lines 4693-4699 in index.html  
**Status:** ✅ FIXED

---

## Critical Fixes Applied

### 🔥 CRITICAL: Image Quality - Always Use High Resolution

**⚠️ NEVER DOWNLOAD LOW-RESOLUTION IMAGES ⚠️**

**Rule:** Always download the highest quality/original images from the live site. Check image URLs for size parameters (s1600, s800, s400, w=800, h=600, etc.) and use the highest available size or remove size parameters entirely. Compare downloaded file sizes with live site images to ensure quality matches.

**Example:**
```powershell
# ❌ BAD - Downloads low-res version
Invoke-WebRequest "https://lh3.googleusercontent.com/image.jpg=s400"

# ✅ GOOD - Downloads high-res version
Invoke-WebRequest "https://lh3.googleusercontent.com/image.jpg=s1600"

# ✅ BETTER - Downloads original
Invoke-WebRequest "https://lh3.googleusercontent.com/image.jpg"
``` (February 1, 2026)

### SUCCESSFUL METHODS - Use These for Future Projects

#### Method 1: Removing /dist/ Prefix from Paths

**Problem:** Script/link tags had `/dist/` in paths causing 404 errors.

**Successful Fix:**
```powershell
$file = "dist\index.html"
(Get-Content $file -Raw) -replace 'src="/dist/', 'src="' -replace 'href="/dist/', 'href="' | Set-Content $file -NoNewline
```

**Key Lesson:** When serving from dist/ folder, all paths must be relative without leading `/dist/`.

---

#### Method 2: Fixing CSS url() Absolute Paths

**Problem:** 7 CSS background images used absolute paths `/images/...` causing 404 errors.

**Locations Fixed:**
- Line 110: `url(/images/backgrounds/1.jpg)` → `url(images/backgrounds/1.jpg)`
- Line 218: `url(/images/x_loader.gif)` → `url(images/x_loader.gif)`
- Lines 234, 247, 251, 255, 259: 5 tooltip icon paths fixed

**Successful Script:**
```powershell
$file = "dist\index.html"
$content = Get-Content $file -Raw
$content = $content -replace 'url\(/images/', 'url(images/'
Set-Content $file $content -NoNewline
```

**Key Lesson:** CSS url() paths must be relative when serving from subdirectories.

---

#### Method 3: Downloading Missing CSS Background Images

**Problem:** 7 images referenced in CSS but not in dist/images/ folder.

**Source:** Downloaded from http://www.indigo-cy.com

**Successful Download Script:**
```powershell
$images = @(
    @{Url="http://www.indigo-cy.com/images/backgrounds/1.jpg"; File="dist\images\backgrounds\1.jpg"},
    @{Url="http://www.indigo-cy.com/images/x_loader.gif"; File="dist\images\x_loader.gif"}
    # + 5 tooltip icons
)

foreach ($img in $images) {
    New-Item -ItemType Directory -Force -Path (Split-Path $img.File -Parent) | Out-Null
    Invoke-WebRequest -Uri $img.Url -OutFile $img.File -UseBasicParsing
    Write-Host "Downloaded: $(Split-Path $img.File -Leaf)"
}
```

**Files Downloaded:**
- backgrounds/1.jpg
- x_loader.gif
- ui_icons/icon_* (5 tooltip icons)

**Key Lesson:** Check CSS files for url() references, not just HTML image tags.

---

#### Method 4: Disabling HTTPS Redirect Script

**Problem:** HTTPS redirect script forced https:// on localhost causing SSL errors (ERR_SSL_PROTOCOL_ERROR).

**Location:** Lines 4693-4699 in dist/index.html

**Successful Fix:**
```html
<!-- User Head Code -->
<!-- HTTPS redirect disabled for localhost development -->
<!--
<script language="JavaScript">
if(window.location.protocol != 'https:')
{ location.href = location.href.replace("http://", "https://"); }
</script>
-->
```

**Key Lesson:** Always disable HTTPS redirects for local development. Re-enable before deployment.

---

#### Method 5: Using file:// Protocol for Testing

**Problem:** http-server kept stopping or refusing connections.

**Successful Alternative:**
```powershell
start chrome "file:///c:/Users/Alaa/Documents/githup/Selenium/publicmatterslebanon/dist/index.html"
```

**Key Lesson:** For static sites without server-side logic, file:// protocol works perfectly and avoids server issues.

---

### Local Testing Methods

**🔐 SSL Server (RECOMMENDED - No HTTPS redirect issues!):**

**Option 1: Quick Start**
```powershell
.\start.ps1
```

**Option 2: Universal Launcher**
```powershell
.\start_ssl_server.ps1 publicmatterslebanon 8080
```

**Option 3: Manual SSL Server**
```powershell
cd dist
http-server -S -C "C:\ssl\localhost+2.pem" -K "C:\ssl\localhost+2-key.pem" -p 8080
# Open: https://127.0.0.1:8080
```

**🛠️ SSL Setup (Already Done!)** - Certificates in C:\ssl\ valid until May 3, 2028

**📋 Stop Server:** `Get-Process node | Stop-Process`

**Alternative Methods (if SSL not needed):**
- **file:// Protocol:** `start chrome "file:///c:/Users/Alaa/Documents/githup/Selenium/publicmatterslebanon/dist/index.html"`
- **http-server:** `cd dist; http-server -p 8080`

**Important:** MUST cd into dist/ folder before starting server.

---

### Complete Project Realization Checklist

✅ **Stage 1-3: Initial Setup**
- Folder created: publicmatterslebanon/
- HTML source obtained (5128 lines)
- Initial testing identified issues

✅ **Stage 4: Image Localization**
- 7 CSS background images downloaded
- Subdirectories created (backgrounds/, ui_icons/)

✅ **Stage 5-6: CSS/JS Localization**
- All external assets already embedded
- Path corrections applied

✅ **Stage 7: JavaScript Fixes**
- No JavaScript modifications needed

✅ **Stage 8: Special Fixes**
- HTTPS redirect disabled (lines 4693-4699)
- All path prefixes corrected

⏳ **Stage 9: Backend Implementation**
- Contact form PHP handler needed
- Email functionality pending

⏳ **Stage 10: Final Testing**
- Cross-browser testing pending
- Form submission testing pending

⏳ **Stage 11: Deployment Package**
- Create .htaccess file
- Create deployment ZIP
- Push to GitHub repository

---

### Important Notes

- Website structure: Has dist/ folder - always serve from there
- All paths now relative and working
- HTTPS redirect commented out for local testing
- Re-enable HTTPS redirect before deployment
- **Deployment:** Create publicmatterslebanon_deployment.zip for Namecheap upload

---

## For New AI Conversations

**You are working on a subproject.** Read the parent guide first:
```
../PROJECT_WORKFLOW_GUIDE.md
```

**This README documents:**
- What has already been done
- Known issues and their fixes
- Current project structure
- Workflow stage progress

**Your job:**
- Continue from where previous work stopped
- Apply remaining workflow stages
- Test and validate the website locally (figure out the method yourself)
- Update this README with new progress

**DO NOT:**
- Re-download already downloaded images
- Re-apply already completed fixes
- Waste time on solved problems

---

## Useful Commands (From Parent Guide)

```powershell
# Navigate to this project
cd "c:\Users\Alaa\Documents\githup\Selenium\publicmatterslebanon"

# Check file sizes
Get-ChildItem -Recurse | Measure-Object -Property Length -Sum

# Search for patterns
Select-String -Path "dist\index.html" -Pattern "https://"

# Download single image
Invoke-WebRequest -Uri "URL" -OutFile "dist\images\filename.jpg"
```

---

**Last Updated:** February 1, 2026  
**Updated By:** AI Session after 4-hour troubleshooting  
**Next Steps:** Continue Stage 9 (Backend) or Stage 10 (Testing)
POST['email'];
$subject = "Contact Form Submission";
```

---

### ✅ Final Verification

After deployment to Namecheap:
- [ ] Website loads with HTTPS (green padlock)
- [ ] All pages accessible and display correctly
- [ ] Images load properly
- [ ] Navigation works (all links functional)
- [ ] Contact form submits successfully
- [ ] Email received at correct address
- [ ] Mobile responsive design working
- [ ] No console errors (F12 DevTools)

---

---

**Last Updated:** February 1, 2026  
**Updated By:** AI Session after 4-hour troubleshooting  
**Next Steps:** Continue Stage 9 (Backend) or Stage 10 (Testing)
