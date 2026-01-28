<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use App\Models\Product;

class ImageHelper
{
	/**
	 * Resolve a product image URL.
	 *
	 * @param string|null $image
	 * @param mixed $product
	 * @param string|int|null $id
	 * @return string
	 */
	public static function productImageUrl($image = null, $product = null, $id = null)
	{
		// 1) explicit image provided
		if ($image) {
			if (str_starts_with($image, 'products/')) {
				return Storage::url($image);
			}
			return asset($image);
		}

		// 2) product provided
		if ($product) {
			$pImage = is_array($product) ? ($product['image'] ?? null) : ($product->image ?? null);
			if ($pImage) {
				if (str_starts_with($pImage, 'products/')) {
					return Storage::url($pImage);
				}
				return asset($pImage);
			}
		}

		// 3) lookup by id/sku/slug
		if ($id) {
			try {
				if (!is_numeric($id)) {
					$prod = Product::where('sku', $id)->orWhere('slug', $id)->first();
				} else {
					$prod = Product::find($id);
				}
				if ($prod && $prod->image) {
					if (str_starts_with($prod->image, 'products/')) {
						return Storage::url($prod->image);
					}
					return asset($prod->image);
				}

				// demo fallback (men-# / women-#)
				if (is_string($id) && preg_match('/^(men|women)-(\d+)$/', $id, $m)) {
					$num = (int) $m[2];
					$imageIndex = ($num % 10) + 1;
					return asset("user/images/card-item{$imageIndex}.jpg");
				}
			} catch (\Throwable $e) {
				// ignore
			}
		}

		// final fallback
		return asset('user/images/card-item1.jpg');
	}
}
