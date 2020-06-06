<?php

namespace AkibTanjim\VirtualClassRoom;

use AkibTanjim\VirtualClassRoom\Rules\Base64Validation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Ixudra\Curl\Facades\Curl;

class ClassRoom
{
    /**
     *
     *
     *
     * Internal Methods
     *
     *
     */
    /**
     *  Method Type : Private
     *  Get Vendor API Request URL from request data and method
     *
     * @param  array  $data
     * @param  string  $method
     * @return string
     */
    private static function getRequestUrl($data, $method)
    {
        $url = env('BRAIN_CERT_BASE_URL') . '/v2/' . $method . '?apikey=' . env('BRAIN_CERT_API_KEY');
        if (array_key_exists('title', $data)) $url .= '&title=' . $data['title'];
        if (array_key_exists('timezone', $data)) $url .= '&timezone=' . $data['timezone'];
        if (array_key_exists('date', $data)) $url .= '&date=' . $data['date'];
        if (array_key_exists('start_time', $data)) $url .= '&start_time=' . $data['start_time'];
        if (array_key_exists('end_time', $data)) $url .= '&end_time=' . $data['end_time'];
        if (array_key_exists('currency', $data)) $url .= '&currency=' . $data['currency'];
        if (array_key_exists('is_paid', $data)) $url .= '&ispaid=' . $data['is_paid'];
        if (array_key_exists('is_recurring', $data)) $url .= '&is_recurring=' . $data['is_recurring'];
        if (array_key_exists('repeat', $data)) $url .= '&repeat=' . $data['repeat'];
        if (array_key_exists('weekdays', $data)) $url .= '&weekdays=' . $data['weekdays'];
        if (array_key_exists('end_classes_count', $data)) $url .= '&end_classes_count=' . $data['end_classes_count'];
        if (array_key_exists('seat_attendees', $data)) $url .= '&seat_attendees=' . $data['seat_attendees'];
        if (array_key_exists('record', $data)) $url .= '&record=' . $data['record'];
        if (array_key_exists('is_video', $data)) $url .= '&isVideo=' . $data['is_video'];
        if (array_key_exists('is_board', $data)) $url .= '&isBoard=' . $data['is_board'];
        if (array_key_exists('is_lang', $data)) $url .= '&isLang=' . $data['is_lang'];
        if (array_key_exists('is_region', $data)) $url .= '&isRegion=' . $data['is_region'];
        if (array_key_exists('is_corporate', $data)) $url .= '&isCorporate=' . $data['is_corporate'];
        if (array_key_exists('is_screenshare', $data)) $url .= '&isScreenshare=' . $data['is_screenshare'];
        if (array_key_exists('published', $data)) $url .= '&published=' . $data['published'];
        if (array_key_exists('start', $data)) $url .= '&limitstart=' . $data['start'];
        if (array_key_exists('limit', $data)) $url .= '&limit=' . $data['limit'];
        if (array_key_exists('search', $data)) $url .= '&search=' . $data['search'];
        if (array_key_exists('class_id', $data) && ($method === "cancelclass" || $method === "getclasslaunch" || $method === "addSchemes" || $method === "listSchemes" || $method === "addSpecials" || $method === "listdiscount" || $method ===  "applycoupon" || $method ===   "getclassrecording" || $method === "availableAttendees")) $url .= '&class_id=' . $data['class_id'];
        if (array_key_exists('class_id', $data) && $method === "removeclass") $url .= '&cid=' . $data['class_id'];
        if (array_key_exists('class_id', $data) && $method === "getclassreport") $url .= '&classId=' . $data['class_id'];
        if (array_key_exists('is_cancel', $data))  $url .= '&isCancel=' . $data['is_cancel'];
        if (array_key_exists('user_id', $data)) $url .= '&userId=' . $data['user_id'];
        if (array_key_exists('user_name', $data)) $url .= '&userName=' . $data['user_name'];
        if (array_key_exists('lesson_name', $data)) $url .= '&lessonName=' . $data['lesson_name'];
        if (array_key_exists('course_name', $data)) $url .= '&courseName=' . $data['course_name'];
        if (array_key_exists('is_teacher', $data)) $url .= '&isTeacher=' . $data['is_teacher'];
        if (array_key_exists('is_extend', $data)) $url .= '&isExtend=' . $data['is_extend'];
        if (array_key_exists('price', $data)) $url .= '&price=' . $data['price'];
        if (array_key_exists('no_of_day', $data))  $url .= '&scheme_days=' . $data['no_of_day'];
        if (array_key_exists('access_type', $data)) $url .= '&times=' . $data['access_type'];
        if (array_key_exists('no_of_max_use', $data)) $url .= '&numbertimes=' . $data['no_of_max_use'];
        if (array_key_exists('price_id', $data)) $url .= '&id=' . $data['price_id'];
        if (array_key_exists('discount', $data)) $url .= '&discount=' . $data['discount'];
        if (array_key_exists('start_date', $data)) $url .= '&start_date=' . $data['start_date'];
        if (array_key_exists('discount_type', $data)) $url .= '&discount_type=' . $data['discount_type'];
        if (array_key_exists('discount_code', $data))  $url .= '&discount_code=' . $data['discount_code'];
        if (array_key_exists('discount_limit', $data)) $url .= '&discount_limit=' . $data['discount_limit'];
        if (array_key_exists('discount_id', $data)) $url .= '&discountid=' . $data['discount_id'];
        if (array_key_exists('record_id', $data) && ($method === 'removeclassrecording' || $method === 'changestatusrecording')) $url .= '&id=' . $data['record_id'];
        if (array_key_exists('record_id', $data) && $method === 'getrecording') $url .= '&record_id=' . $data['record_id'];
        if (array_key_exists('is_recording_layout', $data)) $url .= '&isRecordingLayout=' . $data['is_recording_layout'];
        if (array_key_exists('is_private_chat', $data)) $url .= '&isPrivateChat=' . $data['is_private_chat'];
        $url .= '&format=json';
        return $url;
    }

    /**
     *  Method Type : Private
     *  Pretty Format Validation Error Response
     *
     * @param  array  $errors
     * @return \Illuminate\Http\JsonResponse
     */
    private static function validationErrorsResponseHandler($errors)
    {
        return response()->json([
            'status' => "fail",
            'errors' => $errors,
            'message' => "Invalid Parameter(s)",
        ], 400);
    }
    /**
     *  Method Type : Private
     *  Pretty Format Success Response
     *
     * @param  array  $data
     * @param  string  $message
     * @return \Illuminate\Http\JsonResponse
     */
    private static function successResponseHandler($data, $message)
    {
        return response()->json([
            'status' => "success",
            'data' => $data,
            'message' => $message,
        ], 200);
    }
    /**
     *  Method Type : Private
     *  Pretty Format Custom Error Response
     *
     * @param  string  $message
     * @param  int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    private static function customErrorResponse($message, $statusCode)
    {
        return response()->json([
            'status' => "fail",
            'errors' => [],
            'message' => $message,
        ], $statusCode);
    }

    /**
     *
     *
     *
     *                            Course Related Processes
     *
     *
     */
    /**
     *  Method Type : public
     *  Schedule A Class
     *
     * @param  array  $data
     * @return \Illuminate\Http\JsonResponse
     */
    public static function schedule($data)
    {
        try {
            $validator = Validator::make($data, [
                'title'                 =>  ['required', 'regex:/^[a-zA-Z\- ]*$/'],
                'timezone'              =>  ['required', 'integer'],
                'start_time'            =>  ["required", 'date_format:h:iA'],
                'end_time'              =>  ['required', 'date_format:h:iA'],
                'date'                  =>  ["required", 'date_format:Y-m-d'],
                'currency'              =>  ["max:3", "in:AUD,CAD,EUR,GBP,NZD,USD"],
                'is_paid'               =>  ["in:0,1"],
                'is_recurring'          =>  ["in:0,1"],
                'repeat'                =>  ["in:1,2,3,4,5,6"],
                'weekdays'              =>  ["string"],
                'end_classes_count'     =>  ["integer"],
                'seat_attendees'        =>  ['integer'],
                'record'                =>  ["in:0,1"],
                'is_recording_layout'   =>  ["in:0,1"],
                'is_video'              =>  ["in:0,1"],
                'is_board'              =>  ["in:0,1"],
                'is_lang'               =>  ["integer"],
                'is_region'             =>  ["integer"],
                'is_corporate'          =>  ["in:0,1"],
                'is_screenshare'        =>  ["in:0,1"],
            ]);
            if ($validator->fails()) {
                return self::validationErrorsResponseHandler($validator->errors()->all());
            }
            $api_url = self::getRequestUrl($data, 'schedule');
            $response = Curl::to($api_url)->withContentType('application/json')->post();
            return self::generateResponse($response, "Class scheduled successfully");
        } catch (\Exception $e) {
            Log::error($e);
            return self::customErrorResponse("Internal Error", 500);
        }
    }
    /**
     *  Method Type : public
     *  Fetch All Classes
     *
     * @param  array  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function classList($request)
    {
        try {
            $validator = Validator::make($request, [
                'published' =>  ["in:0,1"],
                'start'     =>  ['integer'],
                'limit'     =>  ['integer'],
                'search'    =>  ['string'],
            ]);
            if ($validator->fails()) {
                return self::validationErrorsResponseHandler($validator->errors()->all());
            }
            $api_url = self::getRequestUrl($request, 'listclass');
            $response = Curl::to($api_url)->withContentType('application/json')->post();
            return self::generateResponse($response, "Class list fetched successfully");
        } catch (\Exception $e) {
            Log::error($e);
            return self::customErrorResponse("Internal Error", 500);
        }
    }
    /**
     *  Method Type : public
     *  Remove A Class
     *
     * @param  array  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function removeClass($request)
    {
        try {
            $validator = Validator::make($request, [
                'class_id' =>   ['required', 'integer'],
            ]);
            if ($validator->fails()) {
                return self::validationErrorsResponseHandler($validator->errors()->all());
            }
            $api_url = self::getRequestUrl($request, 'removeclass');
            $response = Curl::to($api_url)->withContentType('application/json')->post();
            return self::generateResponse($response, "Class removed successfully");
        } catch (\Exception $e) {
            Log::error($e);
            return self::customErrorResponse("Internal Error", 500);
        }
    }
    /**
     *  Method Type : public
     *  Cancel A Class
     *
     * @param  array  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function cancelClass($request)
    {
        try {
            $validator = Validator::make($request, [
                'class_id'  =>  ['required', 'integer'],
                'is_cancel' =>  ['required', 'in:0,1,2'],
            ]);
            if ($validator->fails()) {
                return self::validationErrorsResponseHandler($validator->errors()->all());
            }
            $api_url = self::getRequestUrl($request, 'cancelclass');
            $response = Curl::to($api_url)->withContentType('application/json')->post();
            $status =  $request['is_cancel'] == 0 ? 'activated' : 'cancelled';
            return self::generateResponse($response, "Class $status successfully");
        } catch (\Exception $e) {
            Log::error($e);
            return self::customErrorResponse("Internal Error", 500);
        }
    }
    /**
     *  Method Type : public
     *  Generate A Class Url
     *
     * @param  array  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function launchClass($request)
    {
        try {
            $validator = Validator::make($request, [
                'class_id'      =>  ['required', 'integer'],
                'user_id'       =>  ['required', 'integer'],
                'user_name'     =>  ['required', 'string'],
                'is_teacher'    =>  ['required', 'in:0,1'],
                'lesson_name'   =>  ['required', 'string'],
                'course_name'   =>  ['required', 'string'],
                'is_extend'     =>  ['in:0,1'],
            ]);
            if ($validator->fails()) {
                return self::validationErrorsResponseHandler($validator->errors()->all());
            }
            $api_url = self::getRequestUrl($request, 'getclasslaunch');
            $response = Curl::to($api_url)->withContentType('application/json')->post();
            return self::generateResponse($response, "Class launched successfully");
        } catch (\Exception $e) {
            Log::error($e);
            return self::customErrorResponse("Internal Error", 500);
        }
    }

    /**
     *
     *
     *
     *                            Pricing Scheme Processes
     *
     *
     */

    /**
     *  Method Type : public
     *  Attach A Pricing Scheme To A Class
     *
     * @param  array  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function addScheme($request)
    {
        try {
            $validator = Validator::make($request, [
                'class_id'      =>  ['required', 'integer'],
                'price'         =>  ['required', 'numeric'],
                'no_of_day'     =>  ['required', 'integer'],
                'access_type'   =>  ['required', 'in:0,1'],
                'no_of_max_use' =>  ['integer'],
            ]);
            if ($validator->fails()) {
                return self::validationErrorsResponseHandler($validator->errors()->all());
            }
            $api_url = self::getRequestUrl($request, 'addSchemes');
            $response = Curl::to($api_url)->withContentType('application/json')->post();
            return self::generateResponse($response, "Price Scheme added successfully");
        } catch (\Exception $e) {
            Log::error($e);
            return self::customErrorResponse("Internal Error", 500);
        }
    }
    /**
     *  Method Type : public
     *  Get All Pricing Scheme
     *
     * @param  array  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function schemeList($request)
    {
        try {
            $validator = Validator::make($request, [
                'class_id' =>   ['required', 'integer'],
            ]);
            if ($validator->fails()) {
                return self::validationErrorsResponseHandler($validator->errors()->all());
            }
            $api_url = self::getRequestUrl($request, 'listSchemes');
            $response = Curl::to($api_url)->withContentType('application/json')->post();
            return self::generateResponse($response, "Schemes fetched successfully");
        } catch (\Exception $e) {
            Log::error($e);
            return self::customErrorResponse("Internal Error", 500);
        }
    }
    /**
     *  Method Type : public
     *  Remove A Pricing Scheme
     *
     * @param  array  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function removeScheme($request)
    {
        try {
            $validator = Validator::make($request, [
                'price_id'  =>  ['required', 'integer']
            ]);
            if ($validator->fails()) {
                return self::validationErrorsResponseHandler($validator->errors()->all());
            }
            $api_url = self::getRequestUrl($request, 'removeprice');
            $response = Curl::to($api_url)->withContentType('application/json')->post();
            return self::generateResponse($response, "Scheme removed successfully");
        } catch (\Exception $e) {
            Log::error($e);
            return self::customErrorResponse("Internal Error", 500);
        }
    }
    /**
     *  Method Type : public
     *  Payment Process For A Class
     *
     * @param  array  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function payment($request)
    {
        try {
            $validator = Validator::make($request, [
                'price_id'          =>  ['required', 'integer'],
                'class_id'          =>  ['required', 'integer'],
                'card_number'       =>  ['required'],
                'card_exp_month'    =>  ['required'],
                'card_exp_year'     =>  ['required'],
                'card_cvc'          =>  ['required'],
                'student_email'     =>  ['required', 'email'],
                'cancel_url'        =>  ['required', new Base64Validation],
                'return_url'        =>  ['required', new Base64Validation],
                'coupon_code'       =>  ['string'],
            ]);
            if ($validator->fails()) {
                return self::validationErrorsResponseHandler($validator->errors()->all());
            }
            $request_data   = [
                'apikey'            =>  env('BRAIN_CERT_API_KEY'),
                'class_id'          =>  $request['class_id'],
                'card_number'       =>  $request['card_number'],
                'card_exp_month'    =>  $request['card_exp_month'],
                'card_exp_year'     =>  $request['card_exp_year'],
                'card_cvc'          =>  $request['card_cvc'],
                'student_email'     =>  $request['student_email'],
                'price_id'          =>  $request['price_id'],
                'cancelUrl'         =>  $request['cancel_url'],
                'returnUrl'         =>  $request['return_url'],
                'coupon_code'       =>  array_key_exists('coupon_code', $request) ? $request['coupon_code'] : '',
                'format'            =>  'json'
            ];
            $api_url = env('BRAIN_CERT_BASE_URL') . '/v2/apiclasspayment';
            $response = Curl::to($api_url)->withData($request_data)->asJson()->withContentType('application/json')->post();
            return self::generateResponse($response, "Payment processed successfully");
        } catch (\Exception $e) {
            Log::error($e);
            return self::customErrorResponse("Internal Error", 500);
        }
    }


    /**
     *
     *
     *
     *                            Discount Related Processes
     *
     *
     */

    /**
     *  Method Type : public
     *  Create Discount With OR Without Coupon
     *
     * @param  array  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function addDiscount($request)
    {
        try {
            $validator = Validator::make($request, [
                'class_id'          =>  ['required', 'integer'],
                'discount'          =>  ['required', 'integer'],
                'start_date'        =>  ['required', 'date_format:Y-m-d'],
                'end_date'          =>  ['date_format:Y-m-d'],
                'discount_type'     =>  ['required', 'in:0,1'],
                'discount_code'     =>  ['string'],
                'discount_limit'    =>  ['integer'],
            ]);
            if ($validator->fails()) {
                return self::validationErrorsResponseHandler($validator->errors()->all());
            }
            $api_url = self::getRequestUrl($request, 'addSpecials');
            $response = Curl::to($api_url)->withContentType('application/json')->post();
            return self::generateResponse($response, "Discount added successfully");
        } catch (\Exception $e) {
            Log::error($e);
            return self::customErrorResponse("Internal Error", 500);
        }
    }
    /**
     *  Method Type : public
     *  Get All Discounts
     *
     * @param  array  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function discountList($request)
    {
        try {
            $validator = Validator::make($request, [
                'class_id'          =>  ['required', 'integer'],
                'search'            =>  ['string'],
            ]);
            if ($validator->fails()) {
                return self::validationErrorsResponseHandler($validator->errors()->all());
            }
            $api_url = self::getRequestUrl($request, 'listdiscount');
            $response = Curl::to($api_url)->withContentType('application/json')->post();
            return self::generateResponse($response, "Discount List fetched successfully");
        } catch (\Exception $e) {
            Log::error($e);
            return self::customErrorResponse("Internal Error", 500);
        }
    }
    /**
     *  Method Type : public
     *  Remove Discount For A Specific Discount
     *
     * @param  array  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function removeDiscount($request)
    {
        try {
            $validator = Validator::make($request, [
                'discount_id'  =>  ['required', 'integer']
            ]);
            if ($validator->fails()) {
                return self::validationErrorsResponseHandler($validator->errors()->all());
            }
            $api_url = self::getRequestUrl($request, 'removediscount');
            $response = Curl::to($api_url)->withContentType('application/json')->post();
            return self::generateResponse($response, "Discount removed successfully");
        } catch (\Exception $e) {
            Log::error($e);
            return self::customErrorResponse("Internal Error", 500);
        }
    }
    /**
     *  Method Type : public
     *  Apply Coupon To A Class
     *
     * @param  array  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function applyCoupon($request)
    {
        try {
            $validator = Validator::make($request, [
                'class_id'          =>  ['required', 'integer'],
                'discount_code'     =>  ['required', 'string'],
            ]);
            if ($validator->fails()) {
                return self::validationErrorsResponseHandler($validator->errors()->all());
            }
            $api_url = self::getRequestUrl($request, 'applycoupon');
            $response = Curl::to($api_url)->withContentType('application/json')->post();
            return self::generateResponse($response, "Discount coupon applied successfully");
        } catch (\Exception $e) {
            Log::error($e);
            return self::customErrorResponse("Internal Error", 500);
        }
    }


    /**
     *
     *
     *
     *                            Recording Related Processes
     *
     *
     */

    /**
     *  Method Type : public
     *  Get All Class Recordings
     *
     * @param  array  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function recordingList($request)
    {
        try {
            $validator = Validator::make($request, [
                'class_id'  =>  ['required', 'integer'],
                'search'    =>  ['string'],
            ]);
            if ($validator->fails()) {
                return self::validationErrorsResponseHandler($validator->errors()->all());
            }
            $api_url = self::getRequestUrl($request, 'getclassrecording');
            $response = Curl::to($api_url)->withContentType('application/json')->post();
            return self::generateResponse($response, "Recording list fetched successfully");
        } catch (\Exception $e) {
            Log::error($e);
            return self::customErrorResponse("Internal Error", 500);
        }
    }
    /**
     *  Method Type : public
     *  Get Details Of A Single Recording
     *
     * @param  array  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function getRecording($request)
    {
        try {
            $validator = Validator::make($request, [
                'record_id' =>  ['required', 'integer']
            ]);
            if ($validator->fails()) {
                return self::validationErrorsResponseHandler($validator->errors()->all());
            }
            $api_url = self::getRequestUrl($request, 'getrecording');
            $response = Curl::to($api_url)->withContentType('application/json')->post();
            return self::generateResponse($response, "Recording fetched successfully");
        } catch (\Exception $e) {
            Log::error($e);
            return self::customErrorResponse("Internal Error", 500);
        }
    }
    /**
     *  Method Type : public
     *  Remove A Class Recording
     *
     * @param  array  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function removeRecording($request)
    {
        try {
            $validator = Validator::make($request, [
                'record_id' =>  ['required', 'integer']
            ]);
            if ($validator->fails()) {
                return self::validationErrorsResponseHandler($validator->errors()->all());
            }
            $api_url = self::getRequestUrl($request, 'removeclassrecording');
            $response = Curl::to($api_url)->withContentType('application/json')->post();
            return self::generateResponse($response, "Recording removed successfully");
        } catch (\Exception $e) {
            Log::error($e);
            return self::customErrorResponse("Internal Error", 500);
        }
    }
    /**
     *  Method Type : public
     *  Change Status Of A Recording
     *
     * @param  array  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function changeRecordingStatus($request)
    {
        try {
            $validator = Validator::make($request, [
                'record_id' =>  ['required', 'integer']
            ]);
            if ($validator->fails()) {
                return self::validationErrorsResponseHandler($validator->errors()->all());
            }
            $api_url = self::getRequestUrl($request, 'changestatusrecording');
            $response = Curl::to($api_url)->withContentType('application/json')->post();
            return self::generateResponse($response, "Recording status changed successfully");
        } catch (\Exception $e) {
            Log::error($e);
            return self::customErrorResponse("Internal Error", 500);
        }
    }


    /**
     *
     *
     *
     *                            Report Related Processes
     *
     *
     */

    /**
     *  Method Type : public
     *  Get Class Usage/Engagement Report
     *
     * @param  array  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function classUsageReport($request)
    {
        try {
            $validator = Validator::make($request, [
                'class_id'      =>  ['required', 'integer'],
                'user_id'       =>  ['required', 'integer'],
                'is_teacher'    =>  ['required', 'in:0,1'],
            ]);
            if ($validator->fails()) {
                return self::validationErrorsResponseHandler($validator->errors()->all());
            }
            $api_url = self::getRequestUrl($request, 'getclassreport');
            $response = Curl::to($api_url)->withContentType('application/json')->post();
            return self::generateResponse($response, "Class usage report fetched successfully");
        } catch (\Exception $e) {
            Log::error($e);
            return self::customErrorResponse("Internal Error", 500);
        }
    }
    /**
     *  Method Type : public
     *  Get Attendees Of A Class
     *
     * @param  array  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function getAttendees($request)
    {
        try {
            $validator = Validator::make($request, [
                'class_id'      =>  ['required', 'integer']
            ]);
            if ($validator->fails()) {
                return self::validationErrorsResponseHandler($validator->errors()->all());
            }
            $api_url = self::getRequestUrl($request, 'availableAttendees');
            $response = Curl::to($api_url)->withContentType('application/json')->post();
            return self::generateResponse($response, "Available attendees list fetched successfully");
        } catch (\Exception $e) {
            Log::error($e);
            return self::customErrorResponse("Internal Error", 500);
        }
    }

    /**
     * Return custom response based on response data
     *
     * @param $response
     * @param string $successMessage
     * @return \Illuminate\Http\JsonResponse
     */
    private static function generateResponse($response, $successMessage)
    {
        $responseData = gettype($response) !== "object" ? json_decode($response, true) : (array) $response;
        if (array_key_exists('status', $responseData) && $responseData["status"] === 'error') {
            $customResponse = self::customErrorResponse($responseData["error"], 400);
        } else {
            $customResponse = self::successResponseHandler($responseData, $successMessage);
        }

        return $customResponse;
    }
}
