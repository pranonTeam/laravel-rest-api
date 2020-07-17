<?php

/**
 * Predefined Messages
 */
define('SUCCESS', 'Successfully created');
define('FAIL', 'Failed to create');
define('UPDATE_SUCCESS', 'Successfully updated');
define('UPDATE_FAIL', 'Failed to update');
define('SERVER_ERROR', 'Internal server error!');
define('DELETE_SUCCESS', 'Successfully deleted');
define('DELETE_FAIL', 'Failed to delete');
define('UNAUTHORIZED', 'These credentials do not match our records.');
define('PERMISSION_DENIED', 'Insufficient Permissions!');
define('PAGINATE_LIMIT', 10);

/**
 * Common json response with datas
 */
if (!function_exists('respond')) {
	function respond($data, $key = 'data', $code = 200, $status = true) {
		return response()->json([
			'success' => $status,
			"{$key}" => $data,
		], $code);
	}
}

/**
 * Common json success response
 */
if (!function_exists('respondSuccess')) {
	function respondSuccess($message, $code = 200, $status = true) {
		return response()->json([
			'success' => $status,
			'message' => $message,
		], $code);
	}
}

/**
 * Common json error response
 */
if (!function_exists('respondError')) {
	function respondError($message, $code = 500, $status = false) {
		return response()->json([
			'success' => $status,
			'message' => $message,
		], $code);
	}
}