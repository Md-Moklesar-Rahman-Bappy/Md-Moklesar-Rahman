# Portfolio Builder CMS - User Guide

Welcome to the Portfolio Builder CMS! This guide will help you get started with managing your portfolio website.

---

## Getting Started

### Accessing the Admin Panel

1. Open your browser and navigate to: `http://your-domain.com/admin`
2. Log in with your credentials:
   - **Email:** admin@portfolio.com
   - **Password:** password
3. You will be redirected to the Admin Dashboard.

### First Steps After Login

1. **Update your profile** - Go to Profile to set your name, bio, photo, and resume
2. **Add social links** - Connect your GitHub, LinkedIn, Twitter, etc.
3. **Add content** - Start adding skills, experience, projects, and blog posts
4. The frontend renders all sections automatically in a fixed dark terminal-style layout

---

## Dashboard

The dashboard provides an overview of your portfolio:

- **Total Views** - How many times your portfolio has been viewed
- **Blog Posts** - Number of published blog posts
- **Projects** - Number of projects in your portfolio
- **Messages** - Number of unread contact messages
- **Content Chart** - Visual breakdown of your content
- **Recent Messages** - Latest contact form submissions

---

## Managing Your Profile

Navigate to **Profile** in the sidebar.

- **Full Name** - Your display name
- **Tagline** - Short tagline shown under your name (e.g., "Creative Developer")
- **Designation** - Your job title
- **Bio** - About paragraph
- **Location** - City/Country
- **Email** - Contact email
- **Phone** - Contact phone
- **Website** - Personal website URL
- **Profile Image** - Upload a professional photo
- **Resume PDF** - Upload your resume for download

---

## Skills Management

### Adding Skill Categories
1. Go to **Skills** in the sidebar
2. Click **Add Category** and enter a name
3. Click **Add Skill** within any category

### Adding Skills
1. Click the **Add Skill** button
2. Fill in:
   - **Name** - Skill name (e.g., "Laravel")
   - **Category** - Select from your categories
   - **Percentage** - Proficiency level (0-100)
   - **Color** - Pick a color for the progress bar
3. Click **Save**

Skills display as animated progress bars on your portfolio.

---

## Experience

### Adding Work Experience
1. Go to **Experience** in the sidebar
2. Click **Add Experience**
3. Fill in:
   - **Company Name** - Employer name
   - **Position** - Job title
   - **Location** - Work location
   - **Start Date** - When you started
   - **End Date** - When you ended (or check "Currently Working")
   - **Description** - What you did
   - **Technologies** - Tools/languages you used
4. Click **Save**

Drag and drop to reorder experiences.

---

## Education

1. Go to **Education** in the sidebar
2. Click **Add Education**
3. Fill in institution, degree, field, result, dates, and description
4. Click **Save**

---

## Projects

### Adding a Project Category
1. Go to **Projects** > **Categories** to create categories like "Laravel", "WordPress", etc.

### Adding a Project
1. Go to **Projects** in the sidebar
2. Click **Add Project**
3. Fill in:
   - **Title** - Project name
   - **Category** - Select a category
   - **Description** - Detailed description
   - **Short Description** - Brief summary
   - **Technologies** - Tech stack used
   - **Features** - Key features
   - **GitHub URL** - Source code link
   - **Live URL** - Demo link
   - **Featured** - Mark as featured project
4. Click **Save**

### Adding Project Images
1. Edit a project
2. Scroll to **Project Images** section
3. Upload multiple images with optional captions
4. Images can be reordered by sort order

---

## Services

1. Go to **Services** in the sidebar
2. Click **Add Service**
3. Fill in title, description, icon (Bootstrap Icon class), and features
4. Features should be added as a list (one per line or as JSON array)

---

## Testimonials

1. Go to **Testimonials** in the sidebar
2. Click **Add Testimonial**
3. Fill in client name, company, position, review, and rating (1-5 stars)
4. Click **Save**

---

## Certifications

1. Go to **Certifications** in the sidebar
2. Click **Add Certification**
3. Fill in name, organization, issue date, credential ID, and verification URL
4. Click **Save**

---

## Blog

### Managing Blog Categories
1. Go to **Blog** > **Categories** to create categories like "Web Development", "Tutorials", etc.

### Managing Blog Tags
1. Go to **Blog** > **Tags** to create tags
2. Tags can be added quickly via AJAX from the tags page

### Writing a Blog Post
1. Go to **Blog** in the sidebar
2. Click **Add Post**
3. Fill in:
   - **Title** - Post title
   - **Category** - Select a category
   - **Tags** - Select one or more tags
   - **Excerpt** - Short summary for previews
   - **Content** - Full post content (rich text editor)
   - **Status** - Published or Draft
   - **Published Date** - When to publish
   - **Featured** - Mark as featured post
   - **Reading Time** - Estimated read time in minutes
4. **SEO Settings:**
   - **Meta Title** - Title for search engines
   - **Meta Description** - Description for search results
5. Click **Save**

### Previewing Posts
Click the eye icon on any blog post to see how it looks on the frontend.

---

## Contact Form & Messages

### Viewing Messages
1. Go to **Messages** in the sidebar
2. Messages from the contact form appear in an inbox view
3. Click a message to read it in full
4. Mark messages as read/unread
5. Delete unwanted messages

### Replying to Messages
Open a message and use the reply form to respond directly.

---

## Newsletter

1. Go to **Newsletter** in the sidebar
2. View all newsletter subscribers
3. Export subscribers as CSV (with injection protection)
4. Remove subscribers as needed

---

## SEO Manager

1. Go to **SEO** in the sidebar
2. Configure:
   - **Meta Title** - Default title for all pages
   - **Meta Description** - Default description for search results
   - **OG Title** - Title for social media sharing
   - **OG Description** - Description for social media sharing
   - **OG Image** - Image shown when shared on social media
   - **Twitter Card Type** - Summary or Summary with large image

---

## Analytics

1. Go to **Analytics** in the sidebar
2. View:
   - **Visitors Over Time** - Line chart of daily visitors
   - **Browser Stats** - Doughnut chart of browser usage
   - **Top Countries** - Bar chart of visitor locations
   - **Recent Visitors** - Table with IP, browser, country, pages visited

---

## Site Settings

1. Go to **Settings** in the sidebar
2. Configure:
   - **General** - Site name, tagline, footer text
   - **Contact** - Contact email, phone, address
   - **Social Links** - Facebook, GitHub, LinkedIn, Instagram, YouTube URLs

---

## Media Library

1. Go to **Media** in the sidebar
2. **Upload files** - Drag and drop or click to browse
3. **Browse** - View all uploaded media in a grid
4. **Search** - Filter by filename
5. **Delete** - Remove files you no longer need

Supported formats: JPG, PNG, GIF, WebP, PDF, MP4, and more.

---

## About Section

1. Go to **About** in the sidebar
2. Edit your about section with:
   - **Heading** - Section title
   - **Content** - About text
   - **Counters** - Statistics (years experience, projects, clients, awards)
   - **Achievements** - Notable accomplishments
   - **Image** - Profile/about photo

---

## Frontend Pages

Your portfolio website includes these public pages:

| Page | URL | Description |
|------|-----|-------------|
| Home | `/` | Main landing page with all sections |
| Blog | `/blog` | Blog post listing |
| Blog Post | `/blog/{slug}` | Individual blog post |
| Project | `/project/{slug}` | Individual project detail |
| Contact | `/contact` | Contact form |

The homepage uses a single fixed dark terminal-style layout. Sections (Hero, About, Skills, Experience, Education, Projects, Services, Testimonials, Certifications, Blog, Contact) render directly from your content. Any section without content is hidden automatically.

---

## Tips & Best Practices

1. **Profile Image** - Use a professional headshot, 400x400px recommended
2. **Resume** - Upload a PDF version for easy download
3. **Skills** - Keep percentages realistic (80-95% for strong skills)
4. **Projects** - Add high-quality screenshots and detailed descriptions
5. **Blog** - Write regularly to improve SEO and showcase expertise
6. **SEO** - Fill in all meta fields for better search engine visibility
7. **Mobile** - The frontend layout is fully responsive and mobile-friendly

---

## Troubleshooting

| Issue | Solution |
|-------|----------|
| Images not uploading | Check `storage/` directory permissions. Run `php artisan storage:link` |
| Section not showing on homepage | Add the corresponding content (e.g., skills, projects) in the admin panel |
| Contact form not working | Check that the profile has an email address set |
| Blog post not showing | Ensure status is set to "Published" and published date is today or past |
| 403 Error on admin | Ensure you are logged in with the admin role |
