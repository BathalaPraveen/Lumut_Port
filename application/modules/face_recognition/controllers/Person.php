<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Person extends CI_Controller
{
   public function __construct()
{
    parent::__construct();

    $this->load->model('Person_model');

    $this->load->database();

    $this->load->helper(array(
        'url',
        'form'
    ));

    $this->config->load('constants');

    $this->compreface_url =
        rtrim(
            $this->config->item('compreface_url'),
            '/'
        );

    $this->compreface_api_key =
        $this->config->item('compreface_api_key');

    $this->compreface_threshold =
        $this->config->item('compreface_threshold');
}
    /*
     * Person Registration Page
     */
    public function create()
    {
        $data = array(
            'view_file' => 'persons/create',
        );
        $this->template->load_common_template($data);
    }


    /*
     * Store Person + Register Face
     */
    public function store()
    {
        $this->load->library('upload');

        $person_code = trim(
            $this->input->post('person_code')
        );

        $name = trim(
            $this->input->post('name')
        );

        if ($person_code == '') {

            $this->session->set_flashdata(
                'error',
                'Person code is required.'
            );

            redirect('face_recognition/Person/create');
            return;
        }

        if ($name == '') {

            $this->session->set_flashdata(
                'error',
                'Name is required.'
            );

            redirect('person/create');
            return;
        }


        /*
         * Check duplicate person code
         */
        $existingPerson =
            $this->Person_model
                ->get_by_person_code(
                    $person_code
                );

        if ($existingPerson) {

            $this->session->set_flashdata(
                'error',
                'Person code already exists.'
            );

            redirect('face_recognition/Person/create');
            return;
        }


        /*
         * Check profile image
         */
        if (
            !isset($_FILES['profile_image']) ||
            $_FILES['profile_image']['error'] != 0
        ) {

            $this->session->set_flashdata(
                'error',
                'Profile image is required.'
            );

            redirect('face_recognition/Person/create');
            return;
        }


        /*
         * Check face image
         */
        if (
            !isset($_FILES['face_image']) ||
            $_FILES['face_image']['error'] != 0
        ) {

            $this->session->set_flashdata(
                'error',
                'Face image is required.'
            );

            redirect('face_recognition/Person/create');
            return;
        }


        /*
         * Create upload folder
         */
     

            	$uploadPath = 'public/module/persons/';

        if (!is_dir($uploadPath)) {

            mkdir(
                $uploadPath,
                0755,
                true
            );
        }


        /*
         * Upload Profile Image
         */
        $profileConfig = array(
            'upload_path' =>
                $uploadPath,

            'allowed_types' =>
                'jpg|jpeg|png',

            'max_size' =>
                5120,

            'encrypt_name' =>
                TRUE
        );

        $this->upload->initialize(
            $profileConfig
        );

        if (
            !$this->upload->do_upload(
                'profile_image'
            )
        ) {

            $error =
                $this->upload->display_errors(
                    '',
                    ''
                );

            $this->session->set_flashdata(
                'error',
                $error
            );

            redirect('face_recognition/Person/create');
            return;
        }

        $profileUpload =
            $this->upload->data();

        $profileImage =
            $profileUpload['file_name'];


        /*
         * Face image path
         *
         * We don't necessarily need to
         * save the face image permanently.
         */
        $faceTmpPath =
            $_FILES['face_image']['tmp_name'];

        $faceOriginalName =
            $_FILES['face_image']['name'];


        /*
         * Start DB transaction
         */
        $this->db->trans_begin();


        try {

            /*
             * Subject = Person Code
             */
            $subject = $person_code;


            /*
             * STEP 1
             *
             * Create Subject in CompreFace
             */
            $subjectResponse =
                $this->create_subject(
                    $subject
                );


            /*
             * Subject creation failed
             */
            if (
                !$subjectResponse['success']
            ) {

                throw new Exception(
                    'CompreFace subject creation failed: ' .
                    $subjectResponse['body']
                );
            }


            /*
             * STEP 2
             *
             * Register Face
             */
            $faceResponse =
                $this->register_face(
                    $subject,
                    $faceTmpPath,
                    $faceOriginalName
                );


            if (
                !$faceResponse['success']
            ) {

                throw new Exception(
                    'CompreFace face registration failed: ' .
                    $faceResponse['body']
                );
            }


            /*
             * STEP 3
             *
             * Save person in MySQL
             */
            $personData = array(

                'person_code' =>
                    $person_code,

                'name' =>
                    $name,

                'date_of_birth' =>
                    $this->input->post(
                        'date_of_birth'
                    ) ?: NULL,

                'gender' =>
                    $this->input->post(
                        'gender'
                    ) ?: NULL,

                'phone' =>
                    $this->input->post(
                        'phone'
                    ) ?: NULL,

                'email' =>
                    $this->input->post(
                        'email'
                    ) ?: NULL,

                'department' =>
                    $this->input->post(
                        'department'
                    ) ?: NULL,

                'designation' =>
                    $this->input->post(
                        'designation'
                    ) ?: NULL,

                'company' =>
                    $this->input->post(
                        'company'
                    ) ?: NULL,

                'address' =>
                    $this->input->post(
                        'address'
                    ) ?: NULL,

                'profile_image' =>
                    $profileImage,

                'face_subject' =>
                    $subject,

                'status' =>
                    1
            );


            $personId =
                $this->Person_model
                    ->create_person(
                        $personData
                    );


            if (!$personId) {

                throw new Exception(
                    'Unable to save person.'
                );
            }


            /*
             * Commit transaction
             */
            if (
                $this->db->trans_status()
            ) {

                $this->db->trans_commit();

            } else {

                throw new Exception(
                    'Database transaction failed.'
                );
            }


            $this->session->set_flashdata(
                'success',
                'Person registered successfully.'
            );

            redirect('face_recognition/Person/create');


        } catch (Exception $e) {

            /*
             * Rollback
             */
            $this->db->trans_rollback();


            /*
             * Remove uploaded profile image
             */
            if ($profileImage != '') {

                $profilePath =
                    $uploadPath .
                    $profileImage;

                if (
                    file_exists(
                        $profilePath
                    )
                ) {

                    unlink(
                        $profilePath
                    );
                }
            }


            $this->session->set_flashdata(
                'error',
                $e->getMessage()
            );

            redirect('face_recognition/Person/create');
        }
    }


    /*
     * Create Subject in CompreFace
     */
  private function create_subject($subject)
{
    $url = $this->compreface_url . '/subjects';

    $jsonData = json_encode(array(
        'subject' => $subject
    ));

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);

    curl_setopt($ch, CURLOPT_POST, TRUE);

    curl_setopt(
        $ch,
        CURLOPT_POSTFIELDS,
        $jsonData
    );

    curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        array(
            'x-api-key: ' . $this->compreface_api_key,
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonData)
        )
    );

    curl_setopt(
        $ch,
        CURLOPT_RETURNTRANSFER,
        TRUE
    );

    curl_setopt(
        $ch,
        CURLOPT_TIMEOUT,
        60
    );

    $response = curl_exec($ch);

    $error = curl_error($ch);

    $httpCode = curl_getinfo(
        $ch,
        CURLINFO_HTTP_CODE
    );

    curl_close($ch);


    /*
     * Successful response
     */
    if (
        $httpCode >= 200 &&
        $httpCode < 300
    ) {

        return array(
            'success' => TRUE,
            'body' => $response
        );
    }


    /*
     * Subject already exists
     */
    $responseData = json_decode(
        $response,
        TRUE
    );

    if (
        isset($responseData['code']) &&
        $responseData['code'] == 43
    ) {

        return array(
            'success' => TRUE,
            'body' => $response
        );
    }


    /*
     * Return actual error
     */
    return array(
        'success' => FALSE,
        'body' =>
            $error != ''
                ? $error
                : $response
    );
}

    /*
     * Register Face in CompreFace
     */
    private function register_face(
        $subject,
        $filePath,
        $fileName
    ) {

        $url =
            $this->compreface_url .
            '/faces';


        $file = new CURLFile(
            $filePath,
            mime_content_type(
                $filePath
            ),
            $fileName
        );


        $postData = array(

            'subject' =>
                $subject,

            'file' =>
                $file
        );


        $ch = curl_init();


        curl_setopt(
            $ch,
            CURLOPT_URL,
            $url
        );

        curl_setopt(
            $ch,
            CURLOPT_POST,
            TRUE
        );

        curl_setopt(
            $ch,
            CURLOPT_POSTFIELDS,
            $postData
        );

        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'x-api-key: ' .
                $this->compreface_api_key
            )
        );

        curl_setopt(
            $ch,
            CURLOPT_RETURNTRANSFER,
            TRUE
        );

        curl_setopt(
            $ch,
            CURLOPT_TIMEOUT,
            60
        );


        $response =
            curl_exec($ch);

        $error =
            curl_error($ch);

        $httpCode =
            curl_getinfo(
                $ch,
                CURLINFO_HTTP_CODE
            );

        curl_close($ch);


        if (
            $httpCode >= 200 &&
            $httpCode < 300
        ) {

            return array(
                'success' => TRUE,
                'body' => $response
            );
        }


        return array(
            'success' => FALSE,
            'body' =>
                $error != ''
                    ? $error
                    : $response
        );
    }


    /*
     * Person Scan Page
     */
    public function scan()
    {
      
        $data = array(
            'view_file' => 'persons/scan',
        );
        $this->template->load_common_template($data);
    }


    /*
     * Identify Person
     */
    public function identify()
    {
        /*
         * Check uploaded image
         */
        if (
            !isset($_FILES['image']) ||
            $_FILES['image']['error'] != 0
        ) {

            $this->json_response(
                array(
                    'status' => FALSE,
                    'found' => FALSE,
                    'message' =>
                        'Image is required.'
                ),
                400
            );

            return;
        }


        $filePath =
            $_FILES['image']['tmp_name'];

        $fileName =
            $_FILES['image']['name'];


        /*
         * Send image to CompreFace
         */
        $response =
            $this->recognize_face(
                $filePath,
                $fileName
            );


        if (
            !$response['success']
        ) {

            $this->json_response(
                array(
                    'status' => FALSE,
                    'found' => FALSE,
                    'message' =>
                        'Face recognition failed.',
                    'error' =>
                        $response['body']
                ),
                422
            );

            return;
        }


        $result =
            json_decode(
                $response['body'],
                TRUE
            );


        /*
         * Get first face result
         */
        $faceResult =
            isset(
                $result['result'][0]
            )
                ? $result['result'][0]
                : NULL;


        if (!$faceResult) {

            $this->json_response(
                array(
                    'status' => TRUE,
                    'found' => FALSE,
                    'message' =>
                        'No face detected.'
                )
            );

            return;
        }


        /*
         * Get subjects
         */
        $subjects =
            isset(
                $faceResult['subjects']
            )
                ? $faceResult['subjects']
                : array();


        if (
            empty($subjects)
        ) {

            $this->json_response(
                array(
                    'status' => TRUE,
                    'found' => FALSE,
                    'message' =>
                        'Person not found in our records.'
                )
            );

            return;
        }


        /*
         * Best match
         */
        $match =
            $subjects[0];


        $subject =
            isset(
                $match['subject']
            )
                ? trim(
                    (string)
                    $match['subject']
                )
                : '';


        $similarity =
            isset(
                $match['similarity']
            )
                ? (float)
                    $match['similarity']
                : 0;


        /*
         * Threshold
         */
        $threshold =
            $this->compreface_threshold;


        if (
            $subject == '' ||
            $similarity < $threshold
        ) {

            $this->json_response(
                array(
                    'status' => TRUE,
                    'found' => FALSE,
                    'message' =>
                        'Person not found in our records.',
                    'similarity' =>
                        round(
                            $similarity * 100,
                            2
                        )
                )
            );

            return;
        }


        /*
         * Find person in MySQL
         */
        $person =
            $this->Person_model
                ->get_by_subject(
                    $subject
                );


        if (!$person) {

            $this->json_response(
                array(
                    'status' => TRUE,
                    'found' => FALSE,
                    'message' =>
                        'Face matched, but person record was not found.',
                    'compreface_subject' =>
                        $subject,
                    'similarity' =>
                        round(
                            $similarity * 100,
                            2
                        )
                )
            );

            return;
        }


        /*
         * Profile image URL
         */
        $profileImage = NULL;


        if (
            !empty(
                $person->profile_image
            )
        ) {

            $profileImage =
                base_url(
                    'public/module/persons/' .
                    $person->profile_image
                );
        }


        /*
         * Return person
         */
        $this->json_response(
            array(
                'status' => TRUE,
                'found' => TRUE,
                'message' =>
                    'Person found successfully.',
                'similarity' =>
                    round(
                        $similarity * 100,
                        2
                    ),

                'person' => array(

                    'id' =>
                        $person->id,

                    'person_code' =>
                        $person->person_code,

                    'name' =>
                        $person->name,

                    'date_of_birth' =>
                        $person->date_of_birth,

                    'gender' =>
                        $person->gender,

                    'phone' =>
                        $person->phone,

                    'email' =>
                        $person->email,

                    'department' =>
                        $person->department,

                    'designation' =>
                        $person->designation,

                    'company' =>
                        $person->company,

                    'address' =>
                        $person->address,

                    'profile_image' =>
                        $profileImage
                )
            )
        );
    }


    /*
     * Send image to CompreFace
     */
    private function recognize_face(
        $filePath,
        $fileName
    ) {

        $url =
            $this->compreface_url .
            '/recognize';


        $file = new CURLFile(
            $filePath,
            mime_content_type(
                $filePath
            ),
            $fileName
        );


        $postData = array(

            'file' =>
                $file,

            'prediction_count' =>
                1
        );


        $ch = curl_init();


        curl_setopt(
            $ch,
            CURLOPT_URL,
            $url
        );

        curl_setopt(
            $ch,
            CURLOPT_POST,
            TRUE
        );

        curl_setopt(
            $ch,
            CURLOPT_POSTFIELDS,
            $postData
        );

        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'x-api-key: ' .
                $this->compreface_api_key
            )
        );

        curl_setopt(
            $ch,
            CURLOPT_RETURNTRANSFER,
            TRUE
        );

        curl_setopt(
            $ch,
            CURLOPT_TIMEOUT,
            60
        );


        $response =
            curl_exec($ch);

        $error =
            curl_error($ch);

        $httpCode =
            curl_getinfo(
                $ch,
                CURLINFO_HTTP_CODE
            );

        curl_close($ch);


        if (
            $httpCode >= 200 &&
            $httpCode < 300
        ) {

            return array(
                'success' => TRUE,
                'body' => $response
            );
        }


        return array(
            'success' => FALSE,
            'body' =>
                $error != ''
                    ? $error
                    : $response
        );
    }


    /*
     * JSON response helper
     */
    private function json_response(
        $data,
        $statusCode = 200
    ) {

        $this->output
            ->set_status_header(
                $statusCode
            )
            ->set_content_type(
                'application/json'
            )
            ->set_output(
                json_encode($data)
            );
    }
}
