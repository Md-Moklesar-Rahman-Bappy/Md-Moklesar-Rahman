<?php

use App\Http\Controllers\Admin\{
    DashboardController,
    ProfileController,
    AboutController,
    SkillController,
    SkillCategoryController,
    ExperienceController,
    EducationController,
    ProjectController,
    ProjectCategoryController,
    ProjectImageController,
    ServiceController,
    TestimonialController,
    CertificationController,
    BlogCategoryController,
    BlogTagController,
    BlogPostController,
    MessageController,
    NewsletterController,
    SettingController,
    SeoController,
    AnalyticsController,
    MediaController,
    ThemeController,
    PageSectionController
};
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // About
    Route::get('/about', [AboutController::class, 'edit'])->name('about.edit');
    Route::put('/about', [AboutController::class, 'update'])->name('about.update');

    // Skills
    Route::resource('skills', SkillController::class)->except(['show']);
    Route::post('/skill-categories', [SkillCategoryController::class, 'store'])->name('skill-categories.store');
    Route::put('/skill-categories/{skillCategory}', [SkillCategoryController::class, 'update'])->name('skill-categories.update');
    Route::delete('/skill-categories/{skillCategory}', [SkillCategoryController::class, 'destroy'])->name('skill-categories.destroy');

    // Experience
    Route::resource('experiences', ExperienceController::class)->except(['show']);

    // Education
    Route::resource('educations', EducationController::class)->except(['show']);

    // Projects
    Route::resource('projects', ProjectController::class)->except(['show']);
    Route::resource('project-categories', ProjectCategoryController::class)->except(['show']);
    Route::post('/projects/{project}/images', [ProjectImageController::class, 'store'])->name('projects.images.store');
    Route::delete('/projects/{project}/images/{projectImage}', [ProjectImageController::class, 'destroy'])->name('projects.images.destroy');

    // Services
    Route::resource('services', ServiceController::class)->except(['show']);

    // Testimonials
    Route::resource('testimonials', TestimonialController::class)->except(['show']);

    // Certifications
    Route::resource('certifications', CertificationController::class)->except(['show']);

    // Blog
    Route::resource('blog-categories', BlogCategoryController::class)->except(['show']);
    Route::resource('blog-tags', BlogTagController::class)->except(['show', 'edit', 'update']);
    Route::resource('blog-posts', BlogPostController::class)->except(['show']);

    // Messages
    Route::resource('messages', MessageController::class)->only(['index', 'show', 'destroy']);

    Route::post('/messages/{message}/reply', [MessageController::class, 'reply'])->name('messages.reply');
    Route::put('/messages/{message}/read', [MessageController::class, 'markRead'])->name('messages.mark-read');
    // Newsletter
    Route::get('/newsletter', [NewsletterController::class, 'index'])->name('newsletter.index');
    Route::get('/newsletter/export', [NewsletterController::class, 'export'])->name('newsletter.export');
    Route::delete('/newsletter/{newsletter}', [NewsletterController::class, 'destroy'])->name('newsletter.destroy');

    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');

    // SEO
    Route::get('/seo', [SeoController::class, 'index'])->name('seo.index');
    Route::put('/seo', [SeoController::class, 'update'])->name('seo.update');

    // Analytics
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');
    Route::get('/analytics/data', [AnalyticsController::class, 'data'])->name('analytics.data');

    // Media
    Route::get('/media', [MediaController::class, 'index'])->name('media.index');
    Route::post('/media/upload', [MediaController::class, 'upload'])->name('media.upload');
    Route::delete('/media/{filename}', [MediaController::class, 'destroy'])->name('media.destroy');

    // Themes
    Route::get('/themes', [ThemeController::class, 'index'])->name('themes.index');
    Route::post('/themes/{theme}/activate', [ThemeController::class, 'activate'])->name('themes.activate');
    Route::get('/themes/customize', [ThemeController::class, 'customize'])->name('themes.customize');
    Route::put('/themes/customize', [ThemeController::class, 'updateCustomization'])->name('themes.customize.update');

    // Page Builder
    Route::get('/page-builder', [PageSectionController::class, 'index'])->name('page-builder.index');
    Route::post('/page-builder', [PageSectionController::class, 'store'])->name('page-builder.store');
    Route::put('/page-builder/{pageSection}', [PageSectionController::class, 'update'])->name('page-builder.update');
    Route::delete('/page-builder/{pageSection}', [PageSectionController::class, 'destroy'])->name('page-builder.destroy');
    Route::post('/page-builder/reorder', [PageSectionController::class, 'reorder'])->name('page-builder.reorder');
});
