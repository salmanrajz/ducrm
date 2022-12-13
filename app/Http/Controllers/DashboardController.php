<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
  // Dashboard - Analytics
  public function dashboardAnalytics()
  {
    $pageConfigs = ['pageHeader' => false];

    return view('/content/dashboard/dashboard-analytics', ['pageConfigs' => $pageConfigs]);
  }

  // Dashboard - Ecommerce
  public function dashboardEcommerce()
  {
    $pageConfigs = ['pageHeader' => false];
    $product = product::where('status',1)->get();
    return view('/content/dashboard/dashboard-ecommerce', ['pageConfigs' => $pageConfigs,'product' => $product]);
  }
}
