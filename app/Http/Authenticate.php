protected function redirectTo($request)
{
    if (! $request->expectsJson()) {
        return '/login';
    }
}
