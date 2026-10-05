<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class AdminReviewController extends Controller
{

    public function index(Request $request)
    {

        /*
        |--------------------------------------------------------------------------
        | DATA REVIEW
        |--------------------------------------------------------------------------
        */

        $query = Review::with([
    'user',
    'mitra',
    'order'
]);
/*
|--------------------------------------------------------------------------
| SEARCH
|--------------------------------------------------------------------------
*/

if($request->filled('search'))
{

    $search = $request->search;

    $query->where(function($q) use($search){

        // isi review
        $q->where(
            'review',
            'like',
            "%{$search}%"
        )

        // pelanggan
        ->orWhereHas('user',function($user) use($search){

            $user->where(
                'name',
                'like',
                "%{$search}%"
            );

        })

        // mitra
        ->orWhereHas('mitra',function($mitra) use($search){

            $mitra->where(
                'name',
                'like',
                "%{$search}%"
            )

            ->orWhere(
                'business_name',
                'like',
                "%{$search}%"
            );

        })

        // invoice
        ->orWhereHas('order',function($order) use($search){

            $order->where(
                'invoice_number',
                'like',
                "%{$search}%"
            );

        });

    });

}
/*
|--------------------------------------------------------------------------
| FILTER RATING
|--------------------------------------------------------------------------
*/

if($request->filled('rating'))
{

    $query->where(
        'rating',
        $request->rating
    );

}
/*
|--------------------------------------------------------------------------
| FILTER REVIEW BURUK
|--------------------------------------------------------------------------
*/

if($request->filled('bad'))
{

    if($request->bad=="1")
    {

        $query->where(
            'rating',
            '<=',
            2
        );

    }

}
/*
|--------------------------------------------------------------------------
| FILTER TANGGAL
|--------------------------------------------------------------------------
*/

if($request->filled('from'))
{

    $query->whereDate(
        'created_at',
        '>=',
        $request->from
    );

}

if($request->filled('to'))
{

    $query->whereDate(
        'created_at',
        '<=',
        $request->to
    );

}
/*
|--------------------------------------------------------------------------
| SORTING
|--------------------------------------------------------------------------
*/

switch($request->sort)
{

    case 'oldest':

        $query->oldest();

        break;

    default:

        $query->latest();

        break;

}
$reviews = $query
                ->paginate(10)
                ->withQueryString();

                $totalReview = (clone $query)->count();

$averageRating = round(
    (clone $query)->avg('rating'),
    1
);

$badReview = (clone $query)
                ->where('rating','<=',2)
                ->count();

$fiveStar = (clone $query)
                ->where('rating',5)
                ->count();

        /*
        |--------------------------------------------------------------------------
        | STATISTIK
        |--------------------------------------------------------------------------
        */

        $totalReview = Review::count();

        $averageRating = round(

            Review::avg('rating'),

            1

        );

        $badReview = Review::where(

            'rating',

            '<=',

            2

        )->count();

        $fiveStar = Review::where(

            'rating',

            5

        )->count();

        return view(

            'admin.review.index',

            compact(

                'reviews',

                'totalReview',

                'averageRating',

                'badReview',

                'fiveStar'

            )

        );

    }

    public function show($id)
{

    $review = Review::with([

        'user',

        'mitra',

        'order'

    ])->findOrFail($id);

    return view(

        'admin.review.show',

        compact(

            'review'

        )

    );

}

}