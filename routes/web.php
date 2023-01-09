<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\QuestionBankController;
use App\Http\Controllers\IndividualTestController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentCourseBasedTestController;
use App\Http\Controllers\StudentQuizController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\AdminMiddleware;
use App\Models\CoursedBasedAssignment;
use App\Models\QuestionModules;
use App\Models\Student;

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
Route::post('/getBatch2',[CourseController::class, 'Ajax']);
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
  Route::post('/import/student',[AdminController::class,'import_student'])->name('student.import');
  Route::get('/export/student',[AdminController::class,'sample_export'])->name('student.export');
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
  Route::get('/index/course_based_test',[StudentCourseBasedTestController::class,'index'])->name('course_based_test.index');
  Route::post('CourseBased/QuizPost',[StudentCourseBasedTestController::class,'QuizPost'])->name('course_based_quiz.post');
  Route::get('/CourseBased/Questions/{id}',[StudentCourseBasedTestController::class,'QuestionIndex'])->name('quiz.course_based.question.index');
  Route::post('CourseBasedQuizQuestionPost',[StudentCourseBasedTestController::class,'QuestionPost'])->name('course_based.quiz.question.post');
  Route::post('SpecificQuizQuestionPost',[StudentCourseBasedTestController::class,'SpecificQuizQuestionPost'])->name('course_based.specific.quiz.question.post');
  Route::post('SpecificQuizQuestionAdd',[StudentCourseBasedTestController::class,'SpecificQuizQuestionAdd'])->name('course_based.add.quiz.question.post');
  Route::get('/CourseBasedQuestionShow/{quiz_id}',[StudentCourseBasedTestController::class,'QuestionShow'])->name('quiz.course_based.question.show');
  Route::get('Assignment/index', [QuizController::class, 'AssignmentIndex'])->name('assignment.index');
  Route::post('/AssignmentPost',[QuizController::class, 'AssignmentPost'])->name('course_based_assigmnet.post');
  Route::get('/index/invidual_test',[IndividualTestController::class,'index'])->name('individual_test.index');
  Route::post('/invidual_test/post',[IndividualTestController::class,'QuizPost'])->name('indiviual_test.post');
  Route::get('/index/invidual_test/student/{quiz_id}',[IndividualTestController::class,'student_add_index'])->name('individual.student.index');
  Route::post('/index/invidual_test/student/post',[IndividualTestController::class,'StudentPost'])->name('individual.student.post');
  Route::get('/index/invidual_test/add_question/{quiz_id}',[IndividualTestController::class,'QuestionIndex'])->name('individual.test.question.index');
  Route::post('IndividualQuizQuestionPost',[IndividualTestController::class,'QuestionPost'])->name('individual.quiz.question.post');
  Route::post('IndivudualSpecificQuizQuestionPost',[IndividualTestController::class,'SpecificQuizQuestionPost'])->name('individual.specific.quiz.question.post');
  Route::post('IndividualSpecificQuizQuestionAdd',[IndividualTestController::class,'SpecificQuizQuestionAdd'])->name('individual.add.quiz.question.post');
  Route::get('/IndvidualQuestionShow/{quiz_id}',[IndividualTestController::class,'QuestionShow'])->name('quiz.individual.question.show');
  Route::get('/IndependentQuiz/Delete/{quiz_id}',[QuizController::class,'delete'])->name('independentquiz.delete');
  Route::get('/IndependentQuiz/edit/{quiz_id}',[QuizController::class,'edit'])->name('independentquiz.edit');
  Route::post('/IndependentQuiz/update',[QuizController::class,'update'])->name('quiz.update');
  Route::get('/individualQuiz/edit/{quiz_id}',[IndividualTestController::class,'edit'])->name('individualquiz.edit');
  Route::post('/individualQuiz/update',[IndividualTestController::class,'update'])->name('individualquiz.update');
  Route::get('/individualQuiz/Delete/{quiz_id}',[IndividualTestController::class,'delete'])->name('individualquiz.delete');
  Route::get('/course_based_quiz/edit/{quiz_id}',[StudentCourseBasedTestController::class,'edit'])->name('course_based_quiz.edit');
  Route::post('/course_based_quiz/update',[StudentCourseBasedTestController::class,'update'])->name('course_based_quiz.update');
  Route::get('/course_based_quiz/Delete/{quiz_id}',[StudentCourseBasedTestController::class,'delete'])->name('course_based_quiz.delete');
  Route::get('/course_based_quiz_question/Delete/{question_id}',[StudentCourseBasedTestController::class,'QuestionDelete'])->name('course_based_quiz_question.delete');

  Route::get('/independent_test_question/Delete/{question_id}',[QuizController::class,'QuestionDelete'])->name('independent_test_question.delete');

  Route::get('/individual_test_question/Delete/{question_id}',[IndividualTestController::class,'QuestionDelete'])->name('individual_test_question.delete');

  // Individual Descriptive answers marking
  Route::get('Individual/DescriptiveAnswerMarking/Index',[IndividualTestController::class,'DescriptiveMarkingIndex']);
  Route::get('Individual/DescriptiveAnswerMarking/Marking/{id}',[IndividualTestController::class,'DescriptiveMarkingMarking'])->name('individual.marking');
  Route::post('Individual/DescriptiveAnswerMarking/Marking/post',[IndividualTestController::class,'DescriptiveMarkingMarkingPost'])->name('individual.marking.post');
  // Course Based Descriptive answers marking
  Route::get('CourseBased/DescriptiveAnswerMarking/Index',[StudentCourseBasedTestController::class,'DescriptiveMarkingIndex']);
  Route::get('CourseBased/DescriptiveAnswerMarking/Marking/{id}',[StudentCourseBasedTestController::class,'DescriptiveMarkingMarking'])->name('course_based.marking');
  Route::post('CourseBased/DescriptiveAnswerMarking/Marking/post',[StudentCourseBasedTestController::class,'DescriptiveMarkingMarkingPost'])->name('course_based.marking.post');
  // Independent Descriptive answers marking
  Route::get('independent/DescriptiveAnswerMarking/Index',[QuizController::class,'DescriptiveMarkingIndex']);
  Route::get('independent/DescriptiveAnswerMarking/Marking/{id}',[QuizController::class,'DescriptiveMarkingMarking'])->name('independent.marking');
  Route::post('independent/DescriptiveAnswerMarking/Marking/post',[QuizController::class,'DescriptiveMarkingMarkingPost'])->name('independent.marking.post');
  // Assignment Marking
  Route::get('/Assignment/Index',[AssignmentController::class,'Index']);
  Route::get('Assignment/Marking/{id}',[AssignmentController::class,'Marking'])->name('assignment.marking');
  Route::post('Assignment/Marking/post',[AssignmentController::class,'MarkingPost'])->name('assignment.marking.post');








//
});

//student routes
Route::group(['middleware'=>['auth'],'prefix'=>'student',],function(){
    //Quiz Part
    Route::get('/Quiz/Index',[StudentQuizController::class,'QuizIndex'])->name('student.quiz.index');
    Route::get('/Assignment/Index',[StudentQuizController::class,'AssignmentIndex'])->name('student.assignment.index');
    Route::get('/Quiz/exam/{id}',[StudentQuizController::class,'ExamIndex'])->name('student.exam.index');
    Route::post('/Quiz/exam/post',[StudentQuizController::class,'ExamPost'])->name('student.exam.post');
    Route::get('/Quiz/timeout/{quiz_id}',[StudentQuizController::class,'ExamTimeout']);
    Route::get('/Quiz/course_based/exam/{id}',[StudentCourseBasedTestController::class,'ExamIndex'])->name('student.course_based.exam.index');
    Route::get('/CourseBased/Quiz/timeout/{quiz_id}',[StudentCourseBasedTestController::class,'ExamTimeout']);
    Route::get('/Quiz/individual/exam/{id}',[IndividualTestController::class,'ExamIndex'])->name('student.individual.exam.index');
    //assignment part
    Route::get('/assignment/submission/{id}',[StudentController::class,'AssignmentIndex'])->name('assignment.student.index');
    Route::post('/assignment/submission',[StudentController::class,'AssignmentPost'])->name('assignment.student.post');
    //Course Based Exam Result
    Route::get('/CourseBasedQuizResult/index',[StudentController::class,'CourseBasedQuizResultIndex'])->name('course_based.result');
    


});



