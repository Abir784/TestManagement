<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\QuestionBankController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentQuizController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\AdminMiddleware;
use App\Models\QuestionModules;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::post('/getBatch',[CourseController::class, 'Ajax']);
Route::post('/getModule',[QuizController::class,'Ajax']);
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();

//Admin Routes
Route::group(['middleware'=>['auth','AdminMiddleware'],'prefix'=>'admin',],function(){
    //Student Part
  Route::get('/addstudent',[AdminController::class,'student_index'])->name('add_student.index');
  Route::post('/addstudentPost',[AdminController::class,'student_post'])->name('add_student.post');
  Route::get('/student/show',[AdminController::class,'student_show'])->name('add_student.show');
  Route::get('/student/delete/{id}',[AdminController::class,'student_delete'])->name('student.delete');
  //Course Part
  Route::get('/Addcourse',[CourseController::class,'index'])->name('course.index');
  Route::post('/Addcourse/post',[CourseController::class,'StoreCourse'])->name('course.post');
  Route::get('/Showcourses',[CourseController::class,'showCourse'])->name('course.show');
  Route::get('/Showcourses/delete/{id}',[CourseController::class,'CourseDelete'])->name('course.delete');
  Route::get('/Showcourses/edit/{id}',[CourseController::class,'CourseEdit'])->name('course.edit');
  Route::post('/Addcourse/update',[CourseController::class,'UpdateCourse'])->name('course.update');
  //Batch Part
  Route::get('/AddBatch',[CourseController::class,'IndexBatch'])->name('batch.index');
  Route::post('/AddBatch/create',[CourseController::class,'CreateBatch'])->name('batch.create');
  Route::get('/AddBatch/show',[CourseController::class,'showBatch'])->name('batch.show');
  Route::get('/AddBatch/delete/{id}',[CourseController::class,'DeleteBatch'])->name('batch.delete');
  Route::get('/AddBatch/edit/{id}',[CourseController::class,'EditBatch'])->name('batch.edit');
  //Question Bank Part {Subject}
  Route::get('/AddSubject',[QuestionBankController::class,'SubjectIndex'])->name('subject.index');
  Route::post('/AddSubjectPost',[QuestionBankController::class,'SubjectPost'])->name('subject.store');
  Route::get('/SubjectDelete/{id}',[QuestionBankController::class,'SubjectDelete'])->name('subject.delete');
  //Question Bank Part {Module}
  Route::get('/AddModule',[QuestionBankController::class,'ModuleIndex'])->name('module.index');
  Route::post('/AddModulePost',[QuestionBankController::class,'ModulePost'])->name('module.post');
  Route::get('/ModuleDelete/{id}',[QuestionBankController::class,'ModuleDelete'])->name('module.delete');
// Question Bank Part {Question}
  Route::get('/AddQuestion/{module_id}',[QuestionBankController::class,'QuestionIndex'])->name('question.index');
  Route::post('/AddQuestion/post',[QuestionBankController::class,'QuestionPost'])->name('question.post');
  Route::get('/ShowQuestion/{module_id}',[QuestionBankController::class,'QuestionShow'])->name('question.show');
  Route::get('/DeleteQuestion/{module_id}',[QuestionBankController::class,'QuestionDelete'])->name('question.delete');
  // Quiz Part
  Route::get('/AddQuiz',[QuizController::class,'QuizIndex'])->name('quiz.index');
  Route::post('/QuizPost',[QuizController::class,'QuizPost'])->name('quiz.post');
  Route::get('/AddIndependentTest/Questions/{id}',[QuizController::class,'IndependentQuestionIndex'])->name('quiz.indipendent.question.index');
  Route::post('IndependentQuizQuestionPost',[QuizController::class,'InpendentQuestionPost'])->name('independent.quiz.question.post');
  Route::post('IndependentSpecificQuizQuestionPost',[QuizController::class,'InpendentSpecificQuestionPost'])->name('independent.specific.quiz.question.post');
  Route::get('/InpendentQuestionShow/{quiz_id}',[QuizController::class,'IndependentQuestionShow'])->name('quiz.indipendent.question.show');
  Route::get('/StatusChange/{quiz_id}',[QuizController::class,'StatusChange'])->name('quiz.statuschange');

  Route::post('IndependentSpecificQuizQuestionAdd',[QuizController::class,'IndependentSpecificQuizQuestionAdd'])->name('independent.add.quiz.question.post');


});

//student routes
Route::group(['middleware'=>['auth'],'prefix'=>'student',],function(){
    //Quiz Part
    Route::get('/Quiz/Index',[StudentQuizController::class,'QuizIndex'])->name('student.quiz.index');
    Route::get('/Quiz/exam/{id}',[StudentQuizController::class,'ExamIndex'])->name('student.exam.index');
    Route::post('/Quiz/exam/post',[StudentQuizController::class,'ExamPost'])->name('student.exam.post');

});



