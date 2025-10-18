<?php

class API {

    private $requestMethod;
    private $requestData;

    public function __construct() {
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];
        $this->requestData = $this->getRequestData();
        # debug
        $data = "GET: ".json_encode($_GET)." --POST: ".json_encode($_POST)." --REQ: ".serialize($this->requestData)."\n";
        file_put_contents("0-log.txt", $data, FILE_APPEND | LOCK_EX);
    }

    // Handle incoming requests
    public function handleRequest() {
        switch ($this->requestMethod) {
            case 'GET':     $this->handleGet();     break;
            case 'POST':    $this->handlePost();    break;
            case 'PUT':     $this->handlePut();     break;
            case 'DELETE':  $this->handleDelete();  break;
            default:
                $this->sendResponse(405, ['error' => 'Method Not Allowed']);
            break;
        }
    }

    // Handle GET requests
    private function handleGet() {
        $token = $this->getToken();
        if($token) {
            $token = new Token($token);
            if($token->valid()) {
                $type = pf('type');
                $cmd = pf('cmd');
                if($type=="user") {
                    $user = new Patient((int)$token->get_data()['userId']);
                    if($user->id()>0) {
                        $token->refresh();
                        $response['Token'] = $token->get_token();
                        switch($cmd) {
                            case 'dash':
                                $response['info'] = $user->get_app_graph_points();
                                $this->sendResponse(200, $response);
                            break;
                            case 'apps':
                                $response['info'] = $user->get_app_appointments();
                                $this->sendResponse(200, $response);
                            break;
                            case 'notes':
                                $response['info'] = $user->get_app_notes();
                                $this->sendResponse(200, $response);
                            break;
                            default:
                                $response['error'] = "Invalid command";
                                $this->sendResponse(404, $response);
                            break;
                        }
                    } else {
                        $this->sendResponse(404, ['error' => 'Invalid user ID']);
                    }
                } elseif($type=="doctor") {

                } else {
                    $this->sendResponse(404, ['error' => 'Invalid user']);
                }
            } else {
                $this->sendResponse(401, ['error' => 'Token expired']);
            }
        } else {
            $this->sendResponse(401, ['error' => 'Invalid token']);
        }
    }

    // Handle POST requests
    private function handlePost() {
        $cmd = pf('cmd');
        switch($cmd) {
            case 'login':
                $user = Login::validate_user(pf('email'), pf('password'));
                if($user===false) {
                    $this->sendResponse(401, ['error' => 'Invalid credentials']);
                } else {
                    $token = Token::generate($user);
                    $this->sendResponse(200, ['token' => $token, 'message' => 'OK']);
                }
            break;
            case 'add':
                $token = $this->getToken();
                if($token) {
                    $token = new Token($token);
                    if($token->valid()) {
                        $type = pf('type');
                        if($type=="user") {
                            $user = new Patient((int)$token->get_data()['userId']);
                            if($user->id()>0) {
                                file_put_contents("0-add.txt", json_encode(array( 'weight' => pf('weight'), 'fc' => pf('fc'), 'presis' => pf('presis'), 'predia' => pf('predia'), 'glu' => pf('glu') )), FILE_APPEND | LOCK_EX);
                                $token->refresh();
                                $params = new PatientParams();
                                $values['userId'] = $user->id();
                                $fields = array( 'weight' => pf('weight'), 'fc' => pf('fc'), 'presis' => pf('presis'), 'predia' => pf('predia'), 'glu' => pf('glu') );
                                $values['fields'] = todb($fields, true);
                                $params->set($values);
                                $updated = $params->add();
                                if($updated>0) {
                                    $this->sendResponse(200, ['token' => $token->get_token(), 'message' => 'OK']);
                                }
                            }
                        }
                    }
                }
                $this->sendResponse(401, ['error' => "Something wen't wrong"]);
            break;
            case 'save':
                $token = $this->getToken();
                if($token) {
                    $token = new Token($token);
                    if($token->valid()) {
                        $type = pf('type');
                        if($type=="user") {
                            $user = new Patient((int)$token->get_data()['userId']);
                            if($user->id()>0) {
                                $token->refresh();
                                $values['notes'] = todb( array( 'meds' => pf('meds'), 'ques' => pf('ques') ), true);
                                query_update("admin_users", $values, "userId = ".$user->id());
                                $this->sendResponse(200, ['token' => $token->get_token(), 'message' => "OK"]);
                            }
                        }
                    }
                }
                $this->sendResponse(400, ['error' => "Something wen't wrong"]);
            break;
            default:
                $this->sendREsponse(400, ['error' => "Invalid command"]);
            break;
        }
        $this->sendResponse(200, ['get' => pf('cmd'), 'post' => $_POST]);
        $userid = (isset($_GET['id'])) ? (int)$_GET['id'] : 0;
        $user = new Patient($userid);
        if ($user->id() > 0) {
            if($user->params_add()>0) {
                $this->sendResponse(201, ['message' => 'Data added successfully']);
            } else {
                $this->sendResponse(500, ['error' => 'Failed to add data']);
            }
        } else {
            $this->sendResponse(404, ['error' => 'User not found']);
        }
    }

    // Handle PUT requests
    private function handlePut() {
        // Example: Update data
        $this->sendResponse(200, ['message' => 'PUT request handled']);
    }

    // Handle DELETE requests
    private function handleDelete() {
        // Example: Delete data
        $this->sendResponse(200, ['message' => 'DELETE request handled']);
    }

    // Get the token from the request
    private function getToken() {
        $headers = getallheaders();
        if(isset($headers['Authorization'])) {
            $matches = [];
            if(preg_match('/Bearer\s(\S+)/', $headers['Authorization'], $matches)) {
                return $matches[1];
            }
        }
    }

    // Parse request data
    private function getRequestData() {
        $decoded = json_decode(file_get_contents('php://input'), true);
        return (is_array($decoded)) ? $decoded : [];
    }

    // Send a JSON response
    private function sendResponse($statusCode, $data) {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");
        header("Content-Type: application/json");
        http_response_code($statusCode);
        echo json_encode($data);
        exit;
    }
}
