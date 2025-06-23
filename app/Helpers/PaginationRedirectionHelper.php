<?php

use Illuminate\Http\Request;

if (!function_exists('redirectIfPageExceeds')) {
    /**
     * Redirects to the last available page if the requested page number exceeds the valid range.
     *
     * @param \Illuminate\Http\Request $request The current HTTP request instance
     * @param int $lastPage The last valid page number
     * @param string $redirectRoute The named route to redirect to
     *
     * @return \Illuminate\Http\RedirectResponse|null
     */
    function redirectIfPageExceeds(
        Request $request,
        int $lastPage,
        string $redirectRoute,
    ) {
        if ($request->has('page') && $request->page > $lastPage) {
            return redirect()->route($redirectRoute, ['page' => $lastPage]);
        }
    }
}
