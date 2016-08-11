<?php

namespace YSITD\Http\Controllers;

use Illuminate\Http\Request;

use YSITD\Http\Requests;

use YSITD\User;
use YSITD\Result;
use YSITD\Question;

class ApiController extends Controller
{
    public function random_question(Request $req) {
        // Select or Create User
        $user = User::firstOrCreate(['telegram_id' => $req->user_id]);
        
        // Get Last Answered Question ID
        $last_question_id = $this->getLastQuestionIdByUser($user);
        
        // Get Next Question
        $question = Question::where('id', '>', $last_question_id)->first();
        
        // Return
        if($question !== null) {
            $return_data = [
                'user_id' => $user->telegram_id,
                'question' => $question->question,
                'options' => $question->options,
                'author' => $question->author,
            ];
        } else {
            $return_data = [
                'user_id' => $user->telegram_id
            ];
        }
        
        return $return_data;
    }
    
    public function post_answer(Request $req) {
        // Find out user
        try {
            $user = User::where('telegram_id', '=', $req->user_id)->firstOrFail();
        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $err) {
            return response('Invalid User.', 403);
        }
        
        // Get last question
        $last_question_id = $this->getLastQuestionIdByUser($user);
        
        // Select question
        $question = Question::where('id', '>', $last_question_id)->first();
        
        // Create answered record
        $record = Result::firstOrNew(['user_id' => $user->id, 'question_id' => $question->id]);
        $record->result = $req->correct;
        $record->save();
        
        // Return
        $return_data = [
            'user_id' => $user->telegram_id,
            'answer' => $question->answer,
        ];
        return $return_data;
    }
    
    public function user_status(Request $req) {
        // Find out user
        try {
            $user = User::where('telegram_id', '=', $req->user_id)->firstOrFail();
        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $err) {
            return response('Invalid User.', 403);
        }
        
        // Get correct answer
        $correct = Result::where('user_id', '=', $user->id)->where('result', '=', 1)->count();
        $incorrect = Result::where('user_id', '=', $user->id)->where('result', '=', 0)->count();
        
        // Return
        $return_data = [
            'user_id' => $user->telegram_id,
            'correct' => $correct,
            'incorrect' => $incorrect,
        ];
        return $return_data;
    }
    
    private function getLastQuestionIdByUser($user) {
        // Select Last Answered Result Row
        $last = Result::where('user_id', '=', $user->id)->get()->last();
        
        // If No Any Answered Result, Return Value 0
        $last_question_id = $last ? $last->question_id : '0';
        
        // Return
        return $last_question_id;
    }
}
