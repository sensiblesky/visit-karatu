<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Stakeholder\ListingController as StakeholderListingController;
use App\Http\Controllers\Admin\ListingController as AdminListingController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\SponsorController as AdminSponsorController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/listings', [ListingController::class, 'index'])->name('listings.index');
Route::get('/category/{slug}', [ListingController::class, 'byCategory'])->name('listings.category');
Route::get('/listings/{slug}', [ListingController::class, 'show'])->name('listings.show');
Route::get('/events', [EventController::class, 'index'])->name('events.index');

// Auth required: favorites toggle
Route::middleware('auth')->group(function () {
    Route::post('/favorites/{listing}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
    Route::post('/listings/{listing}/enquire', [EnquiryController::class, 'store'])->name('enquiries.store');
    Route::post('/listings/{listing}/book', [BookingController::class, 'store'])->name('bookings.store');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Stakeholder dashboard
Route::middleware(['auth', 'role:stakeholder,admin'])->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('/bookings', [DashboardController::class, 'bookings'])->name('bookings');
    Route::get('/analytics', [DashboardController::class, 'analytics'])->name('analytics');
    Route::get('/reviews', [DashboardController::class, 'reviews'])->name('reviews');
    Route::get('/messages', [DashboardController::class, 'messages'])->name('messages');

    Route::resource('listings', StakeholderListingController::class);

    // Image management for a listing
    Route::delete('listings/{listing}/images/{image}', [StakeholderListingController::class, 'deleteImage'])->name('listings.images.delete');
    Route::post('listings/{listing}/images/{image}/cover', [StakeholderListingController::class, 'setCoverImage'])->name('listings.images.cover');
    Route::post('listings/{listing}/images/reorder', [StakeholderListingController::class, 'reorderImages'])->name('listings.images.reorder');
});

// Admin panel
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Moderation queue
    Route::get('/', [AdminListingController::class, 'index'])->name('index');
    Route::post('/listings/{listing}/approve', [AdminListingController::class, 'approve'])->name('listings.approve');
    Route::post('/listings/{listing}/reject', [AdminListingController::class, 'reject'])->name('listings.reject');

    // Category management (incl. per-category tab visibility)
    Route::resource('categories', AdminCategoryController::class)->except('show');

    // Sponsor / partner management
    Route::resource('sponsors', AdminSponsorController::class)->except('show');

    // Review moderation
    Route::get('/reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
    Route::post('/reviews/{review}/approve', [AdminReviewController::class, 'approve'])->name('reviews.approve');
    Route::post('/reviews/{review}/reject', [AdminReviewController::class, 'reject'])->name('reviews.reject');
    Route::delete('/reviews/{review}', [AdminReviewController::class, 'destroy'])->name('reviews.destroy');

    // Site-wide settings
    Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [AdminSettingController::class, 'update'])->name('settings.update');
});

require __DIR__.'/auth.php';
