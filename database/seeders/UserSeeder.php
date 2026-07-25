<?php

namespace Database\Seeders;

use App\Models\AboutSection;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\BlogTag;
use App\Models\Certification;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Skill;
use App\Models\SkillCategory;
use App\Models\SocialLink;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        $user = User::create([
            'name' => 'Admin User',
            'email' => 'admin@portfolio.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        $user->assignRole('admin');

        // Create profile
        $profile = $user->profile()->create([
            'full_name' => 'Admin User',
            'tagline' => 'Your Digital Dreamweaver',
            'designation' => 'Senior WordPress Developer',
            'bio' => 'I fuse captivating visuals with seamless functionality to craft immersive online experiences. From sleek designs to unconventional layouts, I bring your vision to life. With over 5 years of experience in web development and design, I specialize in creating beautiful, functional websites that help businesses grow.',
            'experience_years' => 5,
            'location' => 'Dinajpur, Bangladesh',
            'email' => 'md.moklasarrahmanbappy@gmail.com',
            'phone' => '+880-196-5031371',
            'website' => 'https://md-moklesar-rahman-bappy.github.io',
            'slug' => 'md-moklesar-rahman',
        ]);

        // Social links
        $socials = [
            ['platform' => 'github', 'url' => 'https://github.com/Md-Moklesar-Rahman-Bappy', 'icon' => 'fab fa-github'],
            ['platform' => 'linkedin', 'url' => 'https://www.linkedin.com/in/md-moklasar-rahman-bappy', 'icon' => 'fab fa-linkedin-in'],
            ['platform' => 'instagram', 'url' => 'https://www.instagram.com/mr.bappy2/', 'icon' => 'fab fa-instagram'],
            ['platform' => 'youtube', 'url' => 'https://www.youtube.com/@LotsofLaugh-lol', 'icon' => 'fab fa-youtube'],
        ];
        foreach ($socials as $i => $social) {
            SocialLink::create(array_merge($social, ['profile_id' => $profile->id, 'sort_order' => $i, 'is_active' => true]));
        }

        // About section
        AboutSection::create([
            'profile_id' => $profile->id,
            'heading' => 'About Me',
            'content' => 'I am a passionate web developer and graphic designer from Bangladesh. I specialize in WordPress development, web design, and graphic design. I love creating beautiful, functional digital experiences that make a difference.',
            'counters' => [
                ['label' => 'Years Experience', 'value' => 5],
                ['label' => 'Projects Completed', 'value' => 50],
                ['label' => 'Happy Clients', 'value' => 30],
                ['label' => 'Awards Won', 'value' => 5],
            ],
            'achievements' => ['Best Developer Award 2023', 'Top Rated on Upwork', '50+ Projects Completed'],
            'image' => null,
            'sort_order' => 0,
        ]);

        // Skill categories
        $designCat = SkillCategory::create(['profile_id' => $profile->id, 'name' => 'Design', 'slug' => 'design', 'sort_order' => 0]);
        $devCat = SkillCategory::create(['profile_id' => $profile->id, 'name' => 'Development', 'slug' => 'development', 'sort_order' => 1]);
        $cmsCat = SkillCategory::create(['profile_id' => $profile->id, 'name' => 'CMS', 'slug' => 'cms', 'sort_order' => 2]);

        // Skills
        $skills = [
            ['name' => 'Graphics Design', 'percentage' => 95, 'category_id' => $designCat->id, 'color' => '#e91e63', 'sort_order' => 0],
            ['name' => 'Web Design', 'percentage' => 80, 'category_id' => $designCat->id, 'color' => '#9c27b0', 'sort_order' => 1],
            ['name' => 'HTML/CSS', 'percentage' => 95, 'category_id' => $devCat->id, 'color' => '#2196f3', 'sort_order' => 2],
            ['name' => 'JavaScript', 'percentage' => 75, 'category_id' => $devCat->id, 'color' => '#ffeb3b', 'sort_order' => 3],
            ['name' => 'PHP', 'percentage' => 80, 'category_id' => $devCat->id, 'color' => '#7b1fa2', 'sort_order' => 4],
            ['name' => 'Laravel', 'percentage' => 70, 'category_id' => $devCat->id, 'color' => '#f44336', 'sort_order' => 5],
            ['name' => 'WordPress', 'percentage' => 95, 'category_id' => $cmsCat->id, 'color' => '#4caf50', 'sort_order' => 6],
            ['name' => 'WooCommerce', 'percentage' => 85, 'category_id' => $cmsCat->id, 'color' => '#795548', 'sort_order' => 7],
        ];
        foreach ($skills as $skill) {
            Skill::create(array_merge($skill, ['profile_id' => $profile->id, 'is_active' => true]));
        }

        // Experiences
        $experiences = [
            [
                'company_name' => 'Pentagon International Limited',
                'position' => 'Sr. WordPress Developer',
                'location' => 'Dhaka, Bangladesh',
                'start_date' => '2022-07-01',
                'end_date' => '2023-11-30',
                'is_current' => false,
                'description' => 'Led WordPress development projects for enterprise clients. Built custom themes, plugins, and WooCommerce solutions. Managed a team of 3 junior developers.',
                'technologies' => ['WordPress', 'PHP', 'JavaScript', 'WooCommerce', 'ACF'],
                'sort_order' => 0,
            ],
            [
                'company_name' => 'Azmaain Corporation',
                'position' => 'WordPress Developer',
                'location' => 'Dhaka, Bangladesh',
                'start_date' => '2020-03-01',
                'end_date' => '2022-06-15',
                'is_current' => false,
                'description' => 'Developed and maintained WordPress websites for various clients. Created custom themes and plugins. Managed hosting and deployment.',
                'technologies' => ['WordPress', 'PHP', 'MySQL', 'cPanel', 'jQuery'],
                'sort_order' => 1,
            ],
            [
                'company_name' => 'Enigma IT Solution',
                'position' => 'Jr. Web Designer',
                'location' => 'Dhaka, Bangladesh',
                'start_date' => '2019-01-06',
                'end_date' => '2020-02-28',
                'is_current' => false,
                'description' => 'Designed responsive websites using HTML, CSS, and JavaScript. Collaborated with senior developers on client projects.',
                'technologies' => ['HTML', 'CSS', 'JavaScript', 'Photoshop', 'Illustrator'],
                'sort_order' => 2,
            ],
        ];
        foreach ($experiences as $exp) {
            Experience::create(array_merge($exp, ['profile_id' => $profile->id]));
        }

        // Education
        $educations = [
            [
                'institution' => 'Daffodil International University',
                'degree' => 'Bachelor of Science (B.Sc)',
                'group_or_field' => 'Computer Science & Engineering',
                'result' => '3.50/4.00',
                'start_date' => '2014-09-07',
                'end_date' => '2019-04-24',
                'description' => 'Graduated with honors in Computer Science and Engineering. Participated in various tech events and coding competitions.',
                'sort_order' => 0,
            ],
            [
                'institution' => "Queen's School & College",
                'degree' => 'Higher Secondary Certificate (HSC)',
                'group_or_field' => 'Science',
                'result' => '4.50/5.00',
                'start_date' => '2012-07-01',
                'end_date' => '2014-08-13',
                'description' => 'Completed Higher Secondary Certificate in Science group.',
                'sort_order' => 1,
            ],
            [
                'institution' => 'K.B.M. Collegiate High School',
                'degree' => 'Secondary School Certificate (SSC)',
                'group_or_field' => 'Science',
                'result' => '5.00/5.00',
                'start_date' => '2010-01-01',
                'end_date' => '2012-05-07',
                'description' => 'Achieved perfect GPA in Secondary School Certificate.',
                'sort_order' => 2,
            ],
        ];
        foreach ($educations as $edu) {
            Education::create(array_merge($edu, ['profile_id' => $profile->id]));
        }

        // Project categories
        $laravelCat = ProjectCategory::create(['profile_id' => $profile->id, 'name' => 'Laravel', 'slug' => 'laravel', 'sort_order' => 0]);
        $wpCat = ProjectCategory::create(['profile_id' => $profile->id, 'name' => 'WordPress', 'slug' => 'wordpress', 'sort_order' => 1]);
        $designCat = ProjectCategory::create(['profile_id' => $profile->id, 'name' => 'Graphics Design', 'slug' => 'graphics-design', 'sort_order' => 2]);
        $fullstackCat = ProjectCategory::create(['profile_id' => $profile->id, 'name' => 'Full Stack', 'slug' => 'full-stack', 'sort_order' => 3]);
        $saasCat = ProjectCategory::create(['profile_id' => $profile->id, 'name' => 'SaaS', 'slug' => 'saas', 'sort_order' => 4]);

        // Projects
        $projects = [
            [
                'title' => 'Portfolio Builder CMS',
                'slug' => 'portfolio-builder-cms',
                'category_id' => $laravelCat->id,
                'description' => 'An enterprise-grade dynamic portfolio builder CMS built with Laravel 12 and Bootstrap 5.3. Features include multi-theme support, page builder, blog CMS, analytics, and a complete admin dashboard.',
                'short_description' => 'Enterprise portfolio CMS with multi-theme support',
                'technologies' => ['Laravel 12', 'PHP 8.2', 'MySQL', 'Bootstrap 5.3', 'Alpine.js'],
                'features' => ['Multi-theme system', 'Page builder', 'Blog CMS', 'Analytics dashboard', 'Media library'],
                'github_url' => 'https://github.com/Md-Moklesar-Rahman-Bappy/portfolio-builder',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 0,
            ],
            [
                'title' => 'E-Commerce WordPress Theme',
                'slug' => 'ecommerce-wordpress-theme',
                'category_id' => $wpCat->id,
                'description' => 'Custom WooCommerce theme for e-commerce stores with product quick view, wishlist, and advanced filtering.',
                'short_description' => 'Custom WooCommerce e-commerce theme',
                'technologies' => ['WordPress', 'WooCommerce', 'PHP', 'jQuery'],
                'features' => ['Quick view', 'Wishlist', 'Advanced filtering', 'Responsive'],
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Aaroter Dam Logo Design',
                'slug' => 'aaroter-dam-logo',
                'category_id' => $designCat->id,
                'description' => 'Professional brand identity and logo design for Aaroter Dam, including business cards and letterhead.',
                'short_description' => 'Brand identity design',
                'technologies' => ['Photoshop', 'Illustrator'],
                'features' => ['Logo design', 'Brand guidelines', 'Business cards'],
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Inventory Management System',
                'slug' => 'inventory-management-system',
                'category_id' => $fullstackCat->id,
                'description' => 'Full-stack inventory management system with real-time tracking, reporting, and user roles.',
                'short_description' => 'Full-stack inventory tracking system',
                'technologies' => ['Laravel', 'Vue.js', 'MySQL', 'Chart.js'],
                'features' => ['Real-time tracking', 'Reports', 'User roles', 'API'],
                'github_url' => 'https://github.com/Md-Moklesar-Rahman-Bappy/inventory',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'title' => 'SaaS Dashboard Template',
                'slug' => 'saas-dashboard-template',
                'category_id' => $saasCat->id,
                'description' => 'Modern SaaS admin dashboard template with dark mode, charts, and responsive design.',
                'short_description' => 'Modern SaaS admin dashboard',
                'technologies' => ['Laravel', 'Bootstrap 5', 'Chart.js', 'Alpine.js'],
                'features' => ['Dark mode', 'Charts', 'Responsive', 'RTL support'],
                'live_url' => '#',
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'title' => 'Blue Bird Fashion Logo',
                'slug' => 'blue-bird-fashion-logo',
                'category_id' => $designCat->id,
                'description' => 'Creative logo and branding package for Blue Bird Fashion BD.',
                'short_description' => 'Fashion brand logo design',
                'technologies' => ['Photoshop', 'Illustrator'],
                'features' => ['Logo', 'Brand identity', 'Social media kit'],
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 5,
            ],
        ];
        foreach ($projects as $project) {
            Project::create(array_merge($project, ['profile_id' => $profile->id, 'views_count' => rand(10, 200)]));
        }

        // Services
        $services = [
            ['title' => 'WordPress Development', 'slug' => 'wordpress-development', 'description' => 'Custom WordPress themes, plugins, and WooCommerce solutions tailored to your business needs.', 'icon' => 'fab fa-wordpress', 'features' => ['Custom Themes', 'Plugin Development', 'WooCommerce', 'Speed Optimization'], 'sort_order' => 0],
            ['title' => 'Web Design', 'slug' => 'web-design', 'description' => 'Beautiful, responsive website designs that captivate your audience and drive conversions.', 'icon' => 'fas fa-laptop', 'features' => ['UI/UX Design', 'Responsive Design', 'Prototyping', 'Wireframing'], 'sort_order' => 1],
            ['title' => 'Web Development', 'slug' => 'web-development', 'description' => 'Full-stack web development using modern technologies like Laravel, PHP, and JavaScript.', 'icon' => 'fas fa-laptop-code', 'features' => ['Laravel', 'PHP', 'MySQL', 'REST APIs'], 'sort_order' => 2],
            ['title' => 'Graphics Design', 'slug' => 'graphics-design', 'description' => 'Creative graphic design services including logos, branding, and marketing materials.', 'icon' => 'fas fa-pen-nib', 'features' => ['Logo Design', 'Brand Identity', 'Marketing Materials', 'Social Media Graphics'], 'sort_order' => 3],
        ];
        foreach ($services as $service) {
            Service::create(array_merge($service, ['profile_id' => $profile->id, 'is_active' => true]));
        }

        // Testimonials
        $testimonials = [
            ['client_name' => 'Rahim Ahmed', 'company' => 'TechStart BD', 'position' => 'CEO', 'review' => 'Md Moklesar delivered an exceptional WordPress website for our startup. His attention to detail and technical skills are outstanding. Highly recommended!', 'rating' => 5, 'sort_order' => 0],
            ['client_name' => 'Fatima Khan', 'company' => 'Fashion Hub', 'position' => 'Founder', 'review' => 'Amazing graphic design work! The logo and branding package exceeded our expectations. Very professional and creative designer.', 'rating' => 5, 'sort_order' => 1],
            ['client_name' => 'Sakib Hassan', 'company' => 'EduTech Solutions', 'position' => 'CTO', 'review' => 'Great web development skills. Built a complex inventory system that works flawlessly. Very reliable and skilled developer.', 'rating' => 4, 'sort_order' => 2],
        ];
        foreach ($testimonials as $testimonial) {
            Testimonial::create(array_merge($testimonial, ['profile_id' => $profile->id, 'is_active' => true]));
        }

        // Certifications
        $certifications = [
            ['name' => 'WordPress Developer Certification', 'organization' => 'WordPress.org', 'issue_date' => '2022-06-15', 'credential_id' => 'WP-2022-001', 'is_active' => true, 'sort_order' => 0],
            ['name' => 'PHP Development Professional', 'organization' => 'PHP Academy', 'issue_date' => '2021-03-20', 'credential_id' => 'PHP-2021-001', 'is_active' => true, 'sort_order' => 1],
            ['name' => 'UI/UX Design Fundamentals', 'organization' => 'Coursera', 'issue_date' => '2020-11-10', 'credential_id' => 'UX-2020-001', 'is_active' => true, 'sort_order' => 2],
        ];
        foreach ($certifications as $cert) {
            Certification::create(array_merge($cert, ['profile_id' => $profile->id]));
        }

        // Blog categories
        $webDevCat = BlogCategory::create(['profile_id' => $profile->id, 'name' => 'Web Development', 'slug' => 'web-development', 'sort_order' => 0]);
        $tutorialsCat = BlogCategory::create(['profile_id' => $profile->id, 'name' => 'Tutorials', 'slug' => 'tutorials', 'sort_order' => 1]);
        $designCat2 = BlogCategory::create(['profile_id' => $profile->id, 'name' => 'Design Tips', 'slug' => 'design-tips', 'sort_order' => 2]);

        // Blog tags
        $tags = [];
        $tagNames = ['Laravel', 'WordPress', 'PHP', 'JavaScript', 'CSS', 'Design', 'UI/UX', 'Tutorial', 'Tips', 'Web Dev'];
        foreach ($tagNames as $tagName) {
            $tags[] = BlogTag::create(['profile_id' => $profile->id, 'name' => $tagName, 'slug' => Str::slug($tagName)]);
        }

        // Blog posts
        $posts = [
            [
                'title' => 'Getting Started with Laravel 12',
                'slug' => 'getting-started-with-laravel-12',
                'category_id' => $webDevCat->id,
                'excerpt' => 'Learn how to set up a new Laravel 12 project from scratch with best practices.',
                'content' => '<h2>Introduction</h2><p>Laravel 12 brings exciting new features and improvements. In this guide, we will walk through setting up a new project, configuring the environment, and following best practices for a scalable application.</p><h2>Installation</h2><p>First, make sure you have PHP 8.2+ and Composer installed. Then run: <code>composer create-project laravel/laravel my-project</code></p><h2>Configuration</h2><p>Configure your .env file with database credentials and other settings. Laravel 12 makes configuration simpler than ever.</p>',
                'status' => 'published',
                'published_at' => now()->subDays(5),
                'is_featured' => true,
                'reading_time' => 5,
                'meta_title' => 'Getting Started with Laravel 12 - Tutorial',
                'meta_description' => 'Complete guide to setting up Laravel 12 from scratch.',
                'views_count' => 150,
            ],
            [
                'title' => '10 WordPress Performance Tips',
                'slug' => '10-wordpress-performance-tips',
                'category_id' => $tutorialsCat->id,
                'excerpt' => 'Boost your WordPress site speed with these 10 proven optimization techniques.',
                'content' => '<h2>Why Speed Matters</h2><p>A fast website improves user experience, SEO rankings, and conversion rates.</p><h2>1. Choose Quality Hosting</h2><p>Start with a reliable hosting provider that offers SSD storage and good server response times.</p><h2>2. Use a Caching Plugin</h2><p>Plugins like WP Rocket or W3 Total Cache can dramatically improve load times.</p><h2>3. Optimize Images</h2><p>Compress images using tools like TinyPNG or ShortPixel before uploading.</p>',
                'status' => 'published',
                'published_at' => now()->subDays(10),
                'is_featured' => false,
                'reading_time' => 7,
                'views_count' => 230,
            ],
            [
                'title' => 'Modern UI/UX Design Principles',
                'slug' => 'modern-ui-ux-design-principles',
                'category_id' => $designCat2->id,
                'excerpt' => 'Essential design principles every web developer should know in 2024.',
                'content' => '<h2>Design is Not Just About Looks</h2><p>Good design is about solving problems and creating intuitive experiences for users.</p><h2>1. Simplicity</h2><p>Keep your designs clean and focused. Remove unnecessary elements that don\'t serve a purpose.</p><h2>2. Consistency</h2><p>Use consistent colors, fonts, and spacing throughout your design system.</p>',
                'status' => 'published',
                'published_at' => now()->subDays(3),
                'is_featured' => true,
                'reading_time' => 4,
                'views_count' => 95,
            ],
        ];
        foreach ($posts as $post) {
            $blogPost = BlogPost::create(array_merge($post, ['profile_id' => $profile->id]));
            $blogPost->tags()->attach(array_slice($tags, 0, 3));
        }

        // Settings
        $settings = [
            ['key' => 'site_name', 'value' => 'Md Moklesar Rahman', 'group' => 'general'],
            ['key' => 'site_tagline', 'value' => 'Your Digital Dreamweaver', 'group' => 'general'],
            ['key' => 'footer_text', 'value' => 'All rights reserved.', 'group' => 'general'],
            ['key' => 'contact_email', 'value' => 'md.moklasarrahmanbappy@gmail.com', 'group' => 'contact'],
            ['key' => 'contact_phone', 'value' => '+880-196-5031371', 'group' => 'contact'],
            ['key' => 'contact_address', 'value' => 'Ramnogor Mor, Dinajpur-5200, Bangladesh', 'group' => 'contact'],
            ['key' => 'facebook_url', 'value' => '', 'group' => 'social'],
            ['key' => 'github_url', 'value' => 'https://github.com/Md-Moklesar-Rahman-Bappy', 'group' => 'social'],
            ['key' => 'linkedin_url', 'value' => 'https://www.linkedin.com/in/md-moklasar-rahman-bappy', 'group' => 'social'],
            ['key' => 'instagram_url', 'value' => 'https://www.instagram.com/mr.bappy2/', 'group' => 'social'],
            ['key' => 'youtube_url', 'value' => 'https://www.youtube.com/@LotsofLaugh-lol', 'group' => 'social'],
        ];
        foreach ($settings as $setting) {
            Setting::create(array_merge($setting, ['profile_id' => $profile->id, 'type' => 'text']));
        }

        // Create normal demo user
        $normalUser = User::create([
            'name' => 'Demo User',
            'email' => 'user@portfolio.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        $normalUser->profile()->create([
            'full_name' => 'Demo User',
            'tagline' => 'Demo Portfolio User',
            'designation' => 'Web Developer',
            'bio' => 'This is a demo user account for testing purposes.',
            'slug' => 'demo-user',
        ]);
    }
}
