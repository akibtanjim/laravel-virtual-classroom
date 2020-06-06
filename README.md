# Laravel Virtual Classroom API

This package is built for laravel with a view to provide virtual class room api for any website integration. This package uses **BrainCert** **Virtual Classroom API**.
For more information please visit [here](https://www.braincert.com).


## Installation

Install using composer:

```

composer require akibtanjim/virtual-classroom

```

In Laravel 5.5 or higher, this package will be automatically discovered and you can safely skip the following two steps.

If using Laravel 5.4 or lower, after updating composer, add the ServiceProvider to the providers array in ```config/app.php```

In the **providers** section add the below line:

```

  AkibTanjim\VirtualClassRoom\VirtualClassRoomServiceProvider::class,

```
add the Alias to **aliases** section of config/app.php:

```

  'ClassRoom' => AkibTanjim\VirtualClassRoom\Facades\ClassRoom::class,

```

## Usage

In order to facilitate virtual classroom features you need to have a **BrainCert** account. You can sign up from [here](https://www.braincert.com/community/Register).

This package need **API KEY** of **BrainCert** account. You can find your **API KEY** from [here](https://www.braincert.com/app/virtualclassroom). Please put your domain name there. You can also add custom redirect url, your custom logo,favicon,host name etc from **BrainCert Portal**

After you get your **API KEY** open your ```.env``` file and paste the follwing code:

```
BRAIN_CERT_BASE_URL=https://api.braincert.com
BRAIN_CERT_API_KEY=YOUR_API_KEY
```


## Available Methods


1. [ Schedule A Class ](#schedule-a-class)
2. [ Launch A Class ](#launch-a-class)
3. [ List Of Classes ](#list-of-classes)
4. [ Remove A Class ](#remove-a-class)
5. [ Cancel A Class ](#cancel-a-class)
6. [ Add Pricing Scheme ](#add-pricing-scheme)
7. [ List Of Pricing Scheme ](#list-of-pricing-scheme)
8. [ Remove Pricing Scheme ](#remove-pricing-scheme)
9. [ Scheme Payment ](#scheme-payment)
10. [ Add Discount ](#add-discount)
11. [ List Of Discounts ](#list-of-discounts)
12. [ Remove Discount ](#remove-discount)
13. [ Apply Discount Coupon ](#apply-discount-coupon)
14. [ List Of Recordings ](#list-of-recordings)
15. [ Get Recording ](#get-recording)
16. [ Remove Recording ](#remove-recording)
17. [ Change Recording Status ](#change-recording-status)
18. [ Get Class Usage Report ](#get-class-usage-report)
19. [ Get Available Attendees ](#get-available-attendees)

<a name="schedule-a-class"></a>
## Schedule A Class

This method allows to schedule a class.

<details>
    <summary><b>ClassRoom::schedule($request)</b></summary><br />
   
| Parameter 	| Required 	| Data Type 	| Description 	| Example 	|
|-	|-	|-	|-	|-	|
| title 	| Yes 	| String 	| Class title 	| Demo Class 	|
| timezone 	| Yes 	| Integer 	| Class timezone 	| 12 <br /> See <b>Timezone List</b> section for more information                                                                                                                      	|
| start_time 	| Yes 	| String 	| Start time of class 	| 09:30AM 	|
| end_time 	| Yes 	| String 	| End time of class 	| 10:30AM 	|
| date 	| Yes 	| Date 	| Date of class 	| 2020-08-15 	|
| currency 	| No 	| String 	| Currency of class 	| USD<br><br>See the <b>Supported Currency List</b> section for all available currencies 	|
| is_paid 	| No 	| Boolean 	| For class is free or paid 	| 0 for free, 1 for paid 	|
| is_recurring 	| No 	| Boolean 	| Class recurring 	| 0 for No and 1 for Yes 	|
| repeat 	| No 	| Integer 	| When class repeats 	| Value between 1 to 6<br><br>See the <b>Repeat List</b> section for more details 	|
| weekdays 	| No 	| Integer 	| Number for weekdays 	| Comma separated values between 1 to 7<br><br>See <b>Weekdays List</b> section for more details 	|
| end_classes_count 	| No 	| Integer 	| Number of classes for recurring classes 	| 10                                                                                                  	|
| seat_attendees 	| No 	| Integer 	| Number of allowed attendees in a live class 	| 25                                                                                                                                                                                                                                                        	|
| record 	| No 	| Integer 	| Record this class 	| 0 disable recording<br>1 enable recording. Instructor has to manually start/stop recording button.<br>2 start recording automatically when class starts.<br>3 start recording automatically when class starts and disable instructor from managing the recording button. <br>  Recording will be produced at the end of class time. 	|
| is_recording_layout 	| No 	| Integer 	| Recording Layout 	| 0 to use 'Standard layout' for recorded videos that captures minimalistic details <br>such as whiteboard, videos, and chat. <br>(API will assume '0' as default option if you don't pass this parameter).<br><br><br>1 to use 'Enhanced layout' for recorded videos that captures the entire browser tab including all virtual classroom icons and user interface. 	|
| is_video 	| No 	| Integer 	| Video output 	| 0 Produces multiple recorded video files every time instructor clicks the stop recording button or refresh the browser when session is in progress (API will assume '0' as default option if you don't pass this parameter).<br><br><br>1 Concatenates all the recorded video files into a single video file at the end of the session. 	|
| is_board 	| No 	| Integer 	| Allow loading only whiteboard or entire app with audio/video, and group chat. 	| 0 for whiteboard + audio/video + attendee list + chat (API will assume '0' as default option if you don't pass this parameter).<br><br>1 for whiteboard + attendee list.<br><br>2 for whiteboard + attendee list + chat. 	|
| is_lang 	| No 	| Integer 	| Force Interface Language 	| 0 to allow changing interface language by attendees<br><br>- Value between 1 to 50<br><br>See <b>Interface Language List</b> Section for more details 	|
| is_region 	| No 	| Integer 	| Datacenter region selection 	| See <b>Data Center Region List</b> section for more details 	|
| is_corporate 	| No 	| Integer 	| Enable webcam and microphone upon entry 	| 0 to disable webcam and microphone upon entry. Classroom is moderated and instructor has to pass microphone and webcam controls to attendees (API will assume '0' as default option if you don't pass this parameter)<br><br>1 to allow attendees to enable their microphone and webcam without permission from instructor 	|
| is_private_chat 	| No 	| Integer 	| Private chat 	| 0 to allow students to private chat with each other.<br><br><br>1 to enable only instructor to private chat with students and students cannot private chat with each other. 	|
|  	|  	|  	|  	|  	|
|  	|  	|  	|  	|  	|


### Sample Request

```

    ClassRoom::schedule([
        "title" => "demo-class",
        "timezone" => 12,
        "date" => "2020-06-07",
        "start_time" => "07:42AM",
        "end_time" => "08:12AM",
    ]); 

```

### Sample Response

```

    {
        "status": "success",
        "data": {
            "status": "ok",
            "method": "addclass",
            "class_id": 397262,
            "title": "demo-class"
        },
        "message": "Class scheduled successfully"
    }

```

### Error Response

```

    {
        "status": "fail",
        "errors": [
            "The title field is required."
        ],
        "message": "Invalid Parameter(s)"
    }

```

</details>
        


<a name="launch-a-class"></a>
## Launch A Class

This method allows to launch a class which provides a launch url for the class.

<details>
    <summary><b>ClassRoom::launchClass($request)</b></summary><br />
    
| Parameter 	| Required 	| Data Type 	| Description 	| Example 	|
|-	|-	|-	|-	|-	|
| class_id 	| Yes 	| Integer 	| class id 	| 10                                                                                                  	|
| user_id 	| Yes 	| Integer 	| User Id 	| 1         	|
| user_name 	| Yes 	| String 	| User Name 	| Jhon Doe 	|
| is_teacher 	| Yes 	| Integer 	| Marks a user as a teacher or student  	| 0 for Student<br><br>1 for teacher 	|
| lesson_name 	| Yes 	| String 	| Name of the lesson 	| Lesson-01 	|
| course_name 	| Yes 	| String 	| Name of the course 	| Class-01 	|
| is_extend 	| No 	| Integer 	| Allow teacher to extend the class timing 	| 0 for you can extend class.<br>1 for you cannot extend class timer and time is fixed. 	|


### Sample Request

```

    ClassRoom::launchClass([
        "class_id" => 123456,
        "user_id" => 2,
        "user_name" => "Student",
        "is_teacher" => 0,
        "lesson_name" => "Lesson-02",
        "course_name" => "Course-02",
        "is_extend" => 1
    ]);

```


### Sample Response

```

    {
        "status": "success",
        "data": {
            "status": "ok",
            "class_id": "396767",
            "method": "getclasslaunch",
            "launchurl": "LAUNCH_URL",
            "encryptedlaunchurl": "ENCRYPTED_LAUNCH_URL"
        },
        "message": "Class launched successfully"
    }

```

### Error Response

```

    {
        "status": "fail",
        "errors": [
            "The user name field is required."
        ],
        "message": "Invalid Parameter(s)"
    }

```

</details>


<a name="list-of-classes"></a>
## List Of Classes

This method allows to fetch all the classes.

<details>
    <summary><b>ClassRoom::classList($request)</b></summary><br />
    
| Parameter 	| Required 	| Data Type 	| Description 	| Example 	|
|-	|-	|-	|-	|-	|
| published 	| No 	| Integer 	| List published classes only 	| 1 for list published classes<br> <br>0 default to list all classes 	|
| start 	| No 	| Integer 	| Start limit of list class 	| default value is 0 	|
| limit 	| No 	| Integer 	| Limit of list class 	| default value is 10 	|
| search 	| No 	| String 	| Class title 	| Demo 	|



### Sample Request

```

    ClassRoom::classList([
        "published" => 1,
        "start" => 0,
        // "limit" => 5,
        // "search" => "demo"
    ]);

```


### Sample Response

```

     {
        "status": "success",
        "data": {
            "total": 14,
            "classes": [
                    {
                        "isRecordingLayout": "0",
                        "canceled_date": "0000-00-00",
                        "isPrivateChat": "0",
                        "created_by": "0",
                        "instructor_id": "0",
                        "id": "123456",
                        "user_id": "123",
                        "title": "demo-class",
                        "date": "2020-06-07",
                        "start_time": "01:15 PM",
                        "end_time": "01:45 PM",
                        "timezone": "12",
                        "end_date": "0000-00-00",
                        "description": "",
                        "record": "1",
                        "ispaid": "0",
                        "language": "11",
                        "currency": "usd",
                        "status": "Upcoming",
                        "repeat": "0",
                        "virtual_class_type": "html5",
                        "weekdays": "",
                        "seat_attendees": "1",
                        "end_classes_count": "0",
                        "published": "1",
                        "timezone_id": "12",
                        "timezone_country": "Asia/Dhaka",
                        "timezone_label": "Central Asia Standard Time",
                        "difftime": "+06:00",
                        "timezone_title": "(GMT+06:00) Astana, Dhaka",
                        "totalrecords": "0",
                        "duration": 1800,
                        "next_class": 0,
                        "time_to_live_class": null,
                        "next_class_date_time": null,
                        "class_starts_in": 46996,
                        "label": "Central Asia Standard Time",
                        "isVideo": 1,
                        "isRegion": "0",
                        "privacy": "1",
                        "isBoard": "1",
                        "isScreenshare": "1",
                        "isCorporate": "1",
                        "isCancel": "0",
                        "extended_duration": "0",
                        "extended_duration_date": "0000-00-00"
                    },
                    {
                        "isRecordingLayout": "0",
                        "canceled_date": "0000-00-00",
                        "isPrivateChat": "0",
                        "created_by": "0",
                        "instructor_id": "0",
                        "id": "123456",
                        "user_id": "123",
                        "title": "demo-class",
                        "date": "2020-06-07",
                        "start_time": "07:42 AM",
                        "end_time": "08:12 AM",
                        "timezone": "12",
                        "end_date": "0000-00-00",
                        "description": "",
                        "record": "0",
                        "ispaid": "0",
                        "language": "11",
                        "currency": "usd",
                        "status": "Upcoming",
                        "repeat": "0",
                        "virtual_class_type": "html5",
                        "weekdays": "",
                        "seat_attendees": "2",
                        "end_classes_count": "0",
                        "published": "1",
                        "timezone_id": "12",
                        "timezone_country": "Asia/Dhaka",
                        "timezone_label": "Central Asia Standard Time",
                        "difftime": "+06:00",
                        "timezone_title": "(GMT+06:00) Astana, Dhaka",
                        "totalrecords": "0",
                        "duration": 1800,
                        "next_class": 0,
                        "time_to_live_class": null,
                        "next_class_date_time": null,
                        "class_starts_in": 27016,
                        "label": "Central Asia Standard Time",
                        "isVideo": 0,
                        "isRegion": "0",
                        "privacy": "1",
                        "isBoard": "0",
                        "isScreenshare": "1",
                        "isCorporate": "0",
                        "isCancel": "0",
                        "extended_duration": "0",
                        "extended_duration_date": "0000-00-00"
                    }
                ]
        },
        "message": "Class list fetched successfully"
    }

```

### Error Response

```

    {
        "status": "fail",
        "errors": [
            "The limit must be an integer."
        ],
        "message": "Invalid Parameter(s)"
    }

```

</details>



<a name="remove-a-class"></a>
## Remove A Class

This method allows to remove a class.

<details>
    <summary><b>ClassRoom::removeClass($request)</b></summary><br />

| Parameter 	| Required 	| Data Type 	| Description 	| Example 	|
|-	|-	|-	|-	|-	|
| class_id 	| Yes 	| Integer 	| class id 	| 10 


### Sample Request

```

    ClassRoom::removeClass([
        "class_id" => 123456,
    ]);

```


### Sample Response

```

    {
        "status": "success",
        "data": {
            "status": "ok",
            "method": "removeclass",
            "class_id": "123456"
        },
        "message": "Class removed successfully"
    }

```

### Error Response

```

    {
        "status": "fail",
        "errors": [
            "The class id field is required."
        ],
        "message": "Invalid Parameter(s)"
    }

```


</details>

<a name="cancel-a-class"></a>
## Cancel A Class

This method allows to cancel or activate class/recurring class.

<details>
    <summary><b>ClassRoom::cancelClass($request)</b></summary><br />

| Parameter 	| Required 	| Data Type 	| Description 	| Example 	|
|-	|-	|-	|-	|-	|
| class_id 	| Yes 	| Integer 	| class id 	| 10                                                                                                  	|
| is_cancel 	| Yes 	| Integer 	| Allows to cancel current/recurring classes or activate a class  	| 0 Activate canceled class.<br> <br>1 Cancel one-time or current class in the recurring schedule.<br><br> <br>2 Cancel all classes in the recurring schedule. 	|


### Sample Request

```

    ClassRoom::cancelClass([
        "class_id" => 123456,
        "is_cancel" => 1
    ]);

```


### Sample Response

```

    {
        "status": "success",
        "data": {
            "status":"ok",
            "method":"cancelclass",
            "class_id":10
        },
        "message": "Class cancelled successfully"
    }

```

### Error Response

```

    {
        "status": "fail",
        "errors": [
            "The class id field is required."
        ],
        "message": "Invalid Parameter(s)"
    }

```


</details>


<a name="add-pricing-scheme"></a>
## Add Pricing Scheme

This method allows to add a pricing scheme to a class.

<details>
    <summary><b>ClassRoom::addScheme($request)</b></summary><br />

| Parameter 	| Required 	| Data Type 	| Description 	| Example 	|
|-	|-	|-	|-	|-	|
| class_id 	| Yes 	| Integer 	| class id 	| 10                                                                                                  	|
| price 	| Yes 	| Numeric 	| Price of class  	| 10                                                                                                  	|
| no_of_day 	| Yes 	| Integer 	| Days to give access for 	| 30                                                                                                                                                                                                                                                                                                          	|
| access_type 	| Yes 	| Integer 	| Access type for limit 	| 0 for unlimited<br><br>1 for limited 	|
| no_of_max_use 	| No 	| Integer 	| Number of Times price used in class 	| 12                                                                                                                      	|


### Sample Request

```

    ClassRoom::addScheme([
        'class_id'      => 123456,
        'price'         =>  20,
        'no_of_day'     =>  30,
        'access_type'   =>   1,
        'no_of_max_use' =>   1,
    ]);

```


### Sample Response

```

    {
        "status": "success",
        "data": {
            "status": "ok",
            "method": "addprice",
            "price_id": 14
        },
        "message": "Price Scheme added successfully"
    }

```

### Error Response

```

    {
        "status": "fail",
        "errors": [
            "The class id field is required."
        ],
        "message": "Invalid Parameter(s)"
    }

```


</details>


<a name="list-of-pricing-scheme"></a>
## List Of Pricing Scheme

This method allows to fetch all the pricing scheme of a class.

<details>
    <summary><b>ClassRoom::schemeList($request)</b></summary><br />

| Parameter 	| Required 	| Data Type 	| Description 	| Example 	|
|-	|-	|-	|-	|-	|
| class_id 	| Yes 	| Integer 	| class id 	| 10                                                                                                  	|


### Sample Request

```

    ClassRoom::schemeList([
        'class_id'      => 123456
    ]);

```


### Sample Response

```

{
    "status": "success",
    "data": [
        {
            "id": "123",
            "class_id": "123456",
            "scheme_price": "20",
            "scheme_days": "30",
            "lifetime": "0",
            "times": "1",
            "numbertimes": "1",
            "subscription": "0"
        },
        {
            "id": "123",
            "class_id": "123456",
            "scheme_price": "20",
            "scheme_days": "30",
            "lifetime": "0",
            "times": "1",
            "numbertimes": "1",
            "subscription": "0"
        }
    ],
    "message": "Schemes fetched successfully"
}

```

### Error Response

```

    {
        "status": "fail",
        "errors": [
            "The class id field is required."
        ],
        "message": "Invalid Parameter(s)"
    }

```


</details>

<a name="remove-pricing-scheme"></a>
## Remove Pricing Scheme

This method allows to remove pricing scheme of a class.

<details>
    <summary><b>ClassRoom::removeScheme($request)</b></summary><br />

| Parameter 	| Required 	| Data Type 	| Description 	| Example 	|
|-	|-	|-	|-	|-	|
| price_id 	| Yes 	| Integer 	| Price Id 	| 10                                                                                                  	|


### Sample Request

```

    ClassRoom::removeScheme([
        'price_id'      => 123456
    ]);

```


### Sample Response

```

{
    "status": "success",
    "data": [
       "status":"ok",
       "method":"removeprice",
       "price_id":"34"
    ],
    "message": "Scheme removed successfully"
}

```

### Error Response

```

    {
        "status": "fail",
        "errors": [
            "The price id field is required."
        ],
        "message": "Invalid Parameter(s)"
    }

```


</details>


<a name="scheme-payment"></a>
## Scheme Payment

This method allows to make payment of a class scheme.

<details>
    <summary><b>ClassRoom::payment($request)</b></summary><br />

| Parameter 	| Required 	| Data Type 	| Description 	| Example 	|
|-	|-	|-	|-	|-	|
| class_id 	| Yes 	| Integer 	| Class id 	| 10                                                                                                  	|
| price_id 	| Yes 	| Integer 	| Price id 	| 10                                                                                                  	|
| card_number 	| Yes 	| String 	| Card number 	| 4242 4242 4242 4242 	|
| card_exp_month 	| Yes 	| String 	| Card expire month 	| 01        	|
| card_exp_year 	| Yes 	| String 	| Card expire year 	| 2017                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      	|
| card_cvc 	| Yes 	| String 	| Card cvc 	| 141                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               	|
| student_email 	| Yes 	| Email 	| Student Email address 	| yourname@domain.com 	|
| cancel_url 	| Yes 	| Base64 	| Please enter base64 encode url 	| base64_encode('YOUR_CANCEL_URL') 	|
| return_url 	| Yes 	| Base64 	| Please enter base64 encode url 	| base64_encode('YOUR_RETURN_URL') 	|
| coupon_code 	| No 	| String 	| Please enter class coupon code 	| abcd 	|


### Sample Request

```

    ClassRoom::payment([
        'price_id'      => 123,
        'class_id'      => 123456,
        'card_number'   => '4242 4242 4242 4242',
        'card_exp_month' => '01',
        'card_exp_year' => '2017',
        'card_cvc'      => '141',
        'student_email' => 'yourname@domain.com',
        'cancel_url'    => base64_encode('YOUR_CANCEL_URL'),
        'return_url'    => base64_encode('YOUR_RETURN_URL')
    ]);

```


### Sample Response

```

{
    "status": "success",
    "data": {
        "status":"ok",
        "method":"apiclasspayment",
        "charge_id": "ch_1BL9Ae2eZvKYlo2CWz1xDYF1"
    },
    "message": "Payment processed successfully"
}

```

### Error Response

```

    {
        "status": "fail",
        "errors": [
            "The price id field is required."
        ],
        "message": "Invalid Parameter(s)"
    }

```


</details>

<a name="add-discount"></a>
## Add Discount

This method allows to add discount to a class.

<details>
    <summary><b>ClassRoom::addDiscount($request)</b></summary><br />

| Parameter 	| Required 	| Data Type 	| Description 	| Example 	|
|-	|-	|-	|-	|-	|
| class_id 	| Yes 	| Integer 	| Class id 	| 10                                                                                                  	|
| discount 	| Yes 	| Integer 	| Discount of class 	| 10                                                                                                  	|
| start_date 	| Yes 	| Date 	| To Give Access for days of class 	| 2020-06-15 	|
| end_date 	| No 	| Date 	| Discount expires 	| 2020-07-15 	|
| discount_type 	| Yes 	| Integer 	| Discount type in class 	| 0 for fixed_amount<br><br>1 for percentage 	|
| discount_code 	| No 	| String 	| Discount coupon code 	| abcd 	|
| discount_limit 	| No 	| Integer 	| How many times can this discount be used? 	| 10                                                                                                  	|


### Sample Request

```

    ClassRoom::addDiscount([
        'class_id'      => 123456,
        'discount'      => 5,
        'start_date'    => '2020-06-06',
        // 'end_date'      => '2020-06-06',
        'discount_type' => 0,
        // 'discount_code' => 'abcd',
        // 'discount_limit'=> 5,
    ]);

```


### Sample Response

```

    {
        "status": "success",
        "data": {
            "status": "ok",
            "method": "addDiscount",
            "Discount id": 123
        },
        "message": "Discount added successfully"
    }

```

### Error Response

```

    {
        "status": "fail",
        "errors": [
            "The class id field is required."
        ],
        "message": "Invalid Parameter(s)"
    }

```


</details>

<a name="list-of-discounts"></a>
## List Of Discounts

This method allows to fetch discounts of a class.

<details>
    <summary><b>ClassRoom::discountList($request)</b></summary><br />

| Parameter 	| Required 	| Data Type 	| Description 	| Example 	|
|-	|-	|-	|-	|-	|
| class_id 	| Yes 	| Integer 	| Class id 	| 10                                                                                                  	|
| search 	| No 	| String 	| Class title 	| Demo                                                                                                  	|                                                                                              	|


### Sample Request

```

    ClassRoom::discountList([
        'class_id'      => 123456,
    ]);

```


### Sample Response

```

    {
        "status": "success",
        "data": [
            {
               "id":"37",
               "class_id":"598",
               "discount_code":"100code",
               "is_use_discount_code":"1",
               "discount_limit":"55",
               "is_no_limit":"0",
               "discount_type":"fixed_amount",
               "special_price":"100",
               "start_date":"2014-09-01 00:00:00",
               "end_date":"0000-00-00 00:00:00",
               "is_never_expire":"1"
            }
        ],
        "message": "Discount list fetched successfully"
    }

```

### Error Response

```

    {
        "status": "fail",
        "errors": [
            "The class id field is required."
        ],
        "message": "Invalid Parameter(s)"
    }

```


</details>


<a name="remove-discount"></a>
## Remove Discount

This method allows to remove discount from a class.

<details>
    <summary><b>ClassRoom::removeDiscount($request)</b></summary><br />

| Parameter 	| Required 	| Data Type 	| Description 	| Example 	|
|-	|-	|-	|-	|-	|
| discount_id 	| Yes 	| Integer 	| Discount id 	| 10                                                                                                  	|                                                                                           	|


### Sample Request

```

    ClassRoom::discountList([
        'class_id'      => 123456,
    ]);

```


### Sample Response

```

    {
        "status": "success",
        "data": {
           "status":"ok",
           "method":"removediscount",
           "discount_id":"40"
        },
        "message": "Discount removed successfully"
    }

```

### Error Response

```

    {
        "status": "fail",
        "errors": [
            "The discount id field is required."
        ],
        "message": "Invalid Parameter(s)"
    }

```


</details>


<a name="apply-discount-coupon"></a>
## Apply Discount Coupon

This method allows to apply discount to a class.

<details>
    <summary><b>ClassRoom::applyCoupon($request)</b></summary><br />

| Parameter 	| Required 	| Data Type 	| Description 	| Example 	|
|-	|-	|-	|-	|-	|
| class_id 	| Yes 	| Integer 	| Class id 	| 10                                                                                                  	|
| discount_code 	| Yes 	| String 	| Class discount code 	| abcd                                                                                                  	|                                                                                              	|


### Sample Request

```

    ClassRoom::applyCoupon([
        'class_id'      => 123456,
        'discount_code' => 'abcd'
    ]);

```


### Sample Response

```

    {
        "status": "success",
        "data": {
           "error":"0",
           "discount_id":"88"
           "discount_value":"2"
           "discount_type":"percentage"
        },
        "message": "Discount coupon applied successfully"
    }

```

### Error Response

```

    {
        "status": "fail",
        "errors": [
            "The class id field is required."
        ],
        "message": "Invalid Parameter(s)"
    }

```


</details>



<a name="list-of-recordings"></a>
## List Of Recordings

This method allows to fetch all the recordings of a class.

<details>
    <summary><b>ClassRoom::recordingList($request)</b></summary><br />

| Parameter 	| Required 	| Data Type 	| Description 	| Example 	|
|-	|-	|-	|-	|-	|
| class_id 	| Yes 	| Integer 	| Class id 	| 10                                                                                                  	|
| search 	| No 	| String 	| Class title 	| demo                                                                                                  	|                                                                                              	|


### Sample Request

```

    ClassRoom::recordingList([
        'class_id'  => 123456,
        // 'search'    => 'demo'
    ]);

```


### Sample Response

```

    {
        "status": "success",
        "data": [
            {
              "id":"6",
              "classroom_id":"52",
              "user_id":"0",
              "name":"video1369233387010_650002050.webm",
              "fname":"",
              "status":"1",
              "date_recorded":"1969-12-31"
            },
            {
              "id":"8",
              "classroom_id":"52",
              "user_id":"0",
              "name":"video1369231601092_104397168.webm",
              "fname":"","status":"0",
              "date_recorded":"1969-12-31"
            }
        ],
        "message": "Recording list fetched successfully"
    }

```

### Error Response

```

    {
        "status": "fail",
        "errors": [
            "The class id field is required."
        ],
        "message": "Invalid Parameter(s)"
    }

```


</details>




<a name="get-recording"></a>
## Get Recording

This method allows to fetch a specific recording of a class.

<details>
    <summary><b>ClassRoom::getRecording($request)</b></summary><br />

| Parameter 	| Required 	| Data Type 	| Description 	| Example 	|
|-	|-	|-	|-	|-	|
| record_id 	| Yes 	| Integer 	| Record id 	| 10                                                                                                  	|


### Sample Request

```

    ClassRoom::getRecording([
        'record_id'  => 114,
    ]);

```


### Sample Response

```

    {
        "status": "success",
        "data": [
            {
              "id":"114",
              "classroom_id":"483",
              "user_id":"43",
              "name":"20143142521video_483_480325_ready.webm",
              "fname":"",
                    "status":"1",
              "date_recorded":"2014-04-28",
              "record_url":"https:\/\/dm0d88zfsyhg8.cloudfront.net\/20143142521video_483_480325_ready.webm?Expires=1411640160&Signature=WmXk3GV3DMZ7xFHpn9~oRxAG5vbjtTMN~399bZhbF7UPAKJ-xJnKXGPENJffbq5fnsDydb3jAK7vA0O2l5pcz-MPkjqWz13Fg6hPGiT4Vo57gyVe3H9kBWtEAjmZrPaiMMgSweqslx5f9Ytq7D59tez3~qG3pfwW0r59iI8gKHI_&Key-Pair-Id=APKAINGTP6O5WANPM7YQ"
            }
        ],
        "message": "Recording fetched successfully"
    }

```

### Error Response

```

    {
        "status": "fail",
        "errors": [
            "The record id field is required."
        ],
        "message": "Invalid Parameter(s)"
    }

```


</details>


<a name="remove-recording"></a>
## Remove Recording

This method allows to romove a specific recording of a class.

<details>
    <summary><b>ClassRoom::removeRecording($request)</b></summary><br />

| Parameter 	| Required 	| Data Type 	| Description 	| Example 	|
|-	|-	|-	|-	|-	|
| record_id 	| Yes 	| Integer 	| Record id 	| 10                                                                                                  	|


### Sample Request

```

    ClassRoom::removeRecording([
        'record_id'  => 123456,
    ]);

```


### Sample Response

```

    {
        "status": "success",
        "data": {
            "status": "ok",
            "method": "removeclassrecording",
            "record_id": "1234"
        },
        "message": "Recording removed successfully"
    }

```

### Error Response

```

    {
        "status": "fail",
        "errors": [
            "The record id field is required."
        ],
        "message": "Invalid Parameter(s)"
    }

```


</details>


<a name="change-recording-status"></a>
## Change Recording Status

This method allows to change status of a recording of a class.

<details>
    <summary><b>ClassRoom::changeRecordingStatus($request)</b></summary><br />

| Parameter 	| Required 	| Data Type 	| Description 	| Example 	|
|-	|-	|-	|-	|-	|
| record_id 	| Yes 	| Integer 	| Record id 	| 10                                                                                                  	|


### Sample Request

```

    ClassRoom::changeRecordingStatus([
        'record_id'  => 123456,
    ]);

```


### Sample Response

```

    {
        "status": "success",
        "data": {
           "status":"ok",
           "method":"changestatusrecording",
           "record_id":"20"
        },
        "message": "Recording status changed successfully"
    }

```

### Error Response

```

    {
        "status": "fail",
        "errors": [
            "The record id field is required."
        ],
        "message": "Invalid Parameter(s)"
    }

```


</details>



<a name="get-class-usage-report"></a>
## Get Class Usage Report

This method is used to get the total duration and total productivity percentage of attendees. If you pass a specific userId, it will return user specific data

<details>
    <summary><b>ClassRoom::changeRecordingStatus($request)</b></summary><br />

| Parameter 	| Required 	| Data Type 	| Description 	| Example 	|
|-	|-	|-	|-	|-	|
| class_id 	| Yes 	| Integer 	| class id 	| 10                                                                                                  	|
| user_id 	| No 	| Integer 	| User Id 	| 1         	|
| is_teacher 	| No 	| Integer 	| Marks a user as a teacher or student  	| 0 for Student<br><br>1 for teacher 	|


### Sample Request

```

    ClassRoom::classUsageReport([
        'class_id'  => 123456,
        'user_id'   => 1,
        'is_teacher' => 1
    ]);

```


### Sample Response

```

    {
        "status": "success",
        "data": [
           {
              "classId":"1973",
              "userId":"1254",
              "duration":"00:08:55",
              "percentage":"9.91%",
              "attendance":"Yes",
              "session":
              [
                  {
                    "time_in":"Jun 14, 2017 03:01:21 AM",
                    "time_out":"Jun 14, 2017 02:54:49 AM"
                   },
                   {
                    "time_in":"Jun 14, 2017 02:55:02 AM",
                    "time_out":"Jun 14, 2017 03:01:21 AM"
                  },
                  {
                    "time_in":"Jun 14, 2017 03:45:08 AM",
                    "time_out":"Jun 14, 2017 03:46:58 AM"
                  }
              ]      
            }
        ],
        "message": "Class usage report fetched successfully"
    }

```

### Error Response

```

    {
        "status": "fail",
        "errors": [
            "The class id field is required."
        ],
        "message": "Invalid Parameter(s)"
    }

```


</details>


<a name="get-available-attendees"></a>
## Get Available Attendees

This method is used to display the list of available seats when a live class is launched. This is very useful to assign new attendees to a live class by querying the attendee count.

<details>
    <summary><b>ClassRoom::getAttendees($request)</b></summary><br />

| Parameter 	| Required 	| Data Type 	| Description 	| Example 	|
|-	|-	|-	|-	|-	|
| class_id 	| Yes 	| Integer 	| class id 	| 10                                                                                                  	|


### Sample Request

```

    ClassRoom::getAttendees([
        'class_id'  => 123456
    ]);

```


### Sample Response

```

    {
        "status": "success",
        "data": {
            "status": "ok",
            "method": "availableAttendees",
            "class_id": "123456",
            "remaning_attendees": 2
        },
        "message": "Available attendees list fetched successfully"
    }

```

### Error Response

```

    {
        "status": "fail",
        "errors": [
            "The class id field is required."
        ],
        "message": "Invalid Parameter(s)"
    }

```


</details>


##  Timezone List

<details>
    <summary><b>See Full List</b></summary><br />

```

    28=>(GMT) Greenwich Mean Time : Dublin, Edinburgh, Lisbon, London
    30=>(GMT) Monrovia, Reykjavik
    72=>(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna
    53=>(GMT+01:00) Brussels, Copenhagen, Madrid, Paris
    14=>(GMT+01:00) Sarajevo, Skopje, Warsaw, Zagreb
    71=>(GMT+01:00) West Central Africa
    83=>(GMT+02:00) Amman
    84=>(GMT+02:00) Beirut
    24=>(GMT+02:00) Cairo
    61=>(GMT+02:00) Harare, Pretoria
    27=>(GMT+02:00) Helsinki, Kyiv, Riga, Sofia, Tallinn, Vilnius
    35=>(GMT+02:00) Jerusalem
    21=>(GMT+02:00) Minsk
    86=>(GMT+02:00) Windhoek
    31=>(GMT+03:00) Athens, Istanbul, Minsk
    2=>(GMT+03:00) Baghdad
    49=>(GMT+03:00) Kuwait, Riyadh
    54=>(GMT+03:00) Moscow, St. Petersburg, Volgograd
    19=>(GMT+03:00) Nairobi
    87=>(GMT+03:00) Tbilisi
    34=>(GMT+03:30) Tehran
    1=>(GMT+04:00) Abu Dhabi, Muscat
    88=>(GMT+04:00) Baku
    9=>(GMT+04:00) Baku, Tbilisi, Yerevan
    89=>(GMT+04:00) Port Louis
    47=>(GMT+04:30) Kabul
    25=>(GMT+05:00) Ekaterinburg
    90=>(GMT+05:00) Islamabad, Karachi
    73=>(GMT+05:00) Islamabad, Karachi, Tashkent
    33=>(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi
    62=>(GMT+05:30) Sri Jayawardenepura
    91=>(GMT+05:45) Kathmandu
    42=>(GMT+06:00) Almaty, Novosibirsk
    12=>(GMT+06:00) Astana, Dhaka
    41=>(GMT+06:30) Rangoon
    59=>(GMT+07:00) Bangkok, Hanoi, Jakarta
    50=>(GMT+07:00) Krasnoyarsk
    17=>(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi
    46=>(GMT+08:00) Irkutsk, Ulaan Bataar
    60=>(GMT+08:00) Kuala Lumpur, Singapore
    70=>(GMT+08:00) Perth
    63=>(GMT+08:00) Taipei
    65=>(GMT+09:00) Osaka, Sapporo, Tokyo
    77=>(GMT+09:00) Seoul
    75=>(GMT+09:00) Yakutsk
    10=>(GMT+09:30) Adelaide
    4=>(GMT+09:30) Darwin
    20=>(GMT+10:00) Brisbane
    5=>(GMT+10:00) Canberra, Melbourne, Sydney
    74=>(GMT+10:00) Guam, Port Moresby
    64=>(GMT+10:00) Hobart
    69=>(GMT+10:00) Vladivostok
    15=>(GMT+11:00) Magadan, Solomon Is., New Caledonia
    44=>(GMT+12:00) Auckland, Wellington
    26=>(GMT+12:00) Fiji, Kamchatka, Marshall Is.
    6=>(GMT-01:00) Azores
    8=>(GMT-01:00) Cape Verde Is.
    39=>(GMT-02:00) Mid-Atlantic
    22=>(GMT-03:00) Brasilia
    94=>(GMT-03:00) Buenos Aires
    55=>(GMT-03:00) Buenos Aires, Georgetown
    29=>(GMT-03:00) Greenland
    95=>(GMT-03:00) Montevideo
    45=>(GMT-03:30) Newfoundland
    3=>(GMT-04:00) Atlantic Time (Canada)
    57=>(GMT-04:00) Georgetown, La Paz, San Juan
    96=>(GMT-04:00) Manaus
    51=>(GMT-04:00) Santiago
    76=>(GMT-04:30) Caracas
    56=>(GMT-05:00) Bogota, Lima, Quito
    23=>(GMT-05:00) Eastern Time (US & Canada)
    67=>(GMT-05:00) Indiana (East)
    11=>(GMT-06:00) Central America
    16=>(GMT-06:00) Central Time (US & Canada)
    37=>(GMT-06:00) Guadalajara, Mexico City, Monterrey
    7=>(GMT-06:00) Saskatchewan
    68=>(GMT-07:00) Arizona
    38=>(GMT-07:00) Chihuahua, La Paz, Mazatlan
    40=>(GMT-07:00) Mountain Time (US & Canada)
    52=>(GMT-08:00) Pacific Time (US & Canada)
    104=>(GMT-08:00) Tijuana, Baja California
    48=>(GMT-09:00) Alaska
    32=>(GMT-10:00) Hawaii
    58=>(GMT-11:00) Midway Island, Samoa
    18=>(GMT-12:00) International Date Line West
    105=>(GMT-4:00) Eastern Daylight Time (US & Canada)
    13=>GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague


```
</details>


## Supported Currency List

<details>
    <summary><b>See Full List</b></summary><br />
    
```

    AUD 
    CAD 
    EUR 
    GBP 
    NZD 
    USD


```
</details>


## Repeat List

<details>
    <summary><b>See Full List</b></summary><br />
    
```

    1 =>Daily (all 7 days)
    2=>6 Days(Mon-Sat)
    3=>5 Days(Mon-Fri)
    4=>Weekly
    5=>Once every month
    6=>On selected days


```

</details>

## Weekdays List

<details>
    <summary><b>See Full List</b></summary><br />
    
```

    1=> Sunday
    2=> Monday
    3=> Tuesday
    4=> Wednesday
    5=> Thursday
    6=> Friday
    7=> Saturday


```

</details>




##  Interface Language List

<details>
    <summary><b>See Full List</b></summary><br />
    
```

    1 =>arabic
    2 =>bosnian
    3 =>bulgarian
    4 =>catalan
    5 =>chinese-simplified
    6 =>chinese-traditional
    7 =>croatian
    8 =>czech
    9 =>danish
    10 =>dutch
    11 =>english
    12 =>estonian
    13 =>finnish
    14 =>french
    15 =>german
    16 =>greek
    17 =>haitian-creole
    18 =>hebrew
    19 =>hindi
    20 =>hmong-daw
    21 =>hungarian
    22 =>indonesian
    23 =>italian
    24 =>japanese
    25 =>kiswahili
    26 =>klingon
    27 =>korean
    28 =>lithuanian
    29 =>malayalam
    30 =>malay
    31 =>maltese
    32 =>norwegian-bokma
    33 =>persian
    34 =>polish
    35 =>portuguese
    36 =>romanian
    37 =>russian
    38 =>serbian
    39 =>slovak
    40 =>slovenian
    41 =>spanish
    42 =>swedish
    43 =>tamil
    44 =>telugu
    45 =>thai
    46 =>turkish
    47 =>ukrainian
    48 =>urdu
    49 =>vietnamese
    50 =>welsh


```

</details>


##  Data Center Region List

<details>
    <summary><b>See Full List</b></summary><br />
    
```

    0 => Intelligent routing to nearest location
    1 => US East (Dallas, TX)  
    2 => US West (Los Angeles, CA)  
    3 => US East (New York)  
    4 => Europe (Frankfurt, Germany)  
    5 => Europe (London)  
    6 => Asia Pacific (Bangalore, India)  
    7 => Asia Pacific (Singapore)  
    8 => US East (Miami, FL)  
    9 => Europe (Milan, Italy)  
    10 => Asia Pacific (Tokyo, Japan)  
    11 => Middle East (Dubai, UAE)  
    12 => Australia (Sydney)  
    13 => Europe (Paris, France)  
    14 => Asia Pacific (Hong Kong, China)
    15 => Europe (Amsterdam, Netherlands)



```

</details>



## Authors

* **Akib Tanjim** - [akibtanjim](https://github.com/akibtanjim)
* **Alveee** - [Alveee](https://github.com/Alveee)
* **Lutfullahil Kabir Ashik** - [LutfullahilKabirAshik](https://github.com/LutfullahilKabirAshik)

