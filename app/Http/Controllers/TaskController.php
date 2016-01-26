<?php

namespace App\Http\Controllers;

use Event;
use App\Events\TaskCreatedEvent;
use App\Task;
use App\User;
use Illuminate\Http\Request;
use App\Repositories\TaskRepository;
use App\Http\Requests;
use Knp\Snappy\Pdf;

class TaskController extends Controller
{
    /**
     * @var TaskRepository
     */
    protected $tasks;

    public function __construct(TaskRepository $tasks)
    {
        $this->middleware('auth');

        $this->tasks = $tasks;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request) {
        /** @var User $user */
//        $user = $request->user();
//        $tasks = $user->tasks()->getResults();
        //$tasks = Task::where('user_id', $request->user()->id)->orderBy('created_at', 'asc')->get();
        $tasks = $this->tasks->forUser($request->user());

        return view('tasks.index', [
            'tasks' => $tasks
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request) {

        $this->validate($request, [
            'name' => 'required|max:255',
        ]);

        $task = $request->user()->tasks()->create([
            'name' => $request->name,
        ]);

        Event::fire(new TaskCreatedEvent($task));

        return redirect('/tasks');
    }

    /**
     * @param Request $request
     * @param Task $task
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function delete(Request $request, Task $task)
    {

        $this->authorize('delete', $task);

        $task->delete();

        return redirect('/tasks');
    }

    /**
     * @param Request $request
     * @param Task $task
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function hardDelete(Request $request, Task $task)
    {

        $this->authorize('delete', $task);

        $task->forceDelete();

        return redirect('/tasks');
    }

    /**
     * @param Request $request
     * @param Task $task
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function restore(Request $request, Task $task)
    {
        $this->authorize('delete', $task);

        $task->restore();

        return redirect('/tasks');
    }


    public function taskToPDF(Request $request, Task $task)
    {
//        $binary = base_path().'/vendor/h4cc/wkhtmltopdf-amd64/bin/wkhtmltopdf-amd64';
        $binary = '/usr/bin/xvfb-run /usr/bin/wkhtmltopdf';
        $snappy = new Pdf($binary);
        //$html = file_get_contents('http://www.google.com');
        $pdf = base_path().'/storage/app/pdfs/task_id'.$task->id.'.pdf';
        $snappy->generateFromHtml('<h1>'.$task->name.'</h1><p>'.$task->user->name.'</p>', $pdf, array(), true);
        return response()->download($pdf, 'task.pdf',[
            'Content-Type' => 'application/pdf',
                //'Content-Disposition' => 'attachment; filename="file.pdf"',
            ]);

// or you can do it in two steps
//        $snappy = new Pdf();
//        $snappy->setBinary($binary);

//// Display the resulting pdf in the browser
//// by setting the Content-type header to pdf
//        //$snappy = new Pdf($binary);
//        header('Content-Type: application/pdf');
//        header('Content-Disposition: attachment; filename="file.pdf"');
//        echo $snappy->getOutput('http://www.github.com');
//
//// Merge multiple urls into one pdf
//// by sending an array of urls to getOutput()
//        $snappy = new Pdf($binary);
//        header('Content-Type: application/pdf');
//        header('Content-Disposition: attachment; filename="file.pdf"');
//        echo $snappy->getOutput(array('http://www.github.com','http://www.knplabs.com','http://www.php.net'));
//
//// .. or simply save the PDF to a file
//        $snappy = new Pdf($binary);
//        $snappy->generateFromHtml('<h1>Bill</h1><p>You owe me money, dude.</p>', base_path().'/resources/bill-123.pdf');
//        return response();
//
//// Pass options to snappy
//// Type wkhtmltopdf -H to see the list of options
//        $snappy = new Pdf($binary);
//        $snappy->setOption('disable-javascript', true);
//        $snappy->setOption('no-background', true);
//        $snappy->setOption('allow', array('/path1', '/path2'));
//        $snappy->setOption('cookie', array('key' => 'value', 'key2' => 'value2'));
//        $snappy->setOption('cover', 'pathToCover.html');
//// .. or pass a cover as html
//        $snappy->setOption('cover', '<h1>Bill cover</h1>');
//        $snappy->setOption('toc', true);
//        $snappy->setOption('cache-dir', '/path/to/cache/dir');
    }

}
