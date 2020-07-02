<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\{IContact, IDish, IInfo, IPicture, IPrice, IReview, IUser};
use App\Repositories\Eloquent\{ContactRepository,
    DishRepository,
    InfoRepository,
    PictureRepository,
    PriceRepository,
    ReviewRepository,
    UserRepository};

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(IPrice::class, PriceRepository::class);
        $this->app->bind(IPicture::class, PictureRepository::class);
        $this->app->bind(IDish::class, DishRepository::class);
        $this->app->bind(IInfo::class, InfoRepository::class);
        $this->app->bind(IContact::class, ContactRepository::class);
        $this->app->bind(IReview::class, ReviewRepository::class);
        $this->app->bind(IUser::class, UserRepository::class);

    }
}
