<?php


namespace KBS\Controllers;

use KBS\Entities\Employer;
use KBS\Request\Errors\Error;
use KBS\Entities\WorkExpierence;
use KBS\Request\Validator\Validator;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class WorkExpierenceController extends BaseController
{

    /**
     * Returns the index page.
     *
     * @param \Psr\Http\Message\RequestInterface  $request
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return mixed
     * @throws \ReflectionException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function index(RequestInterface $request, ResponseInterface $response)
    {
        $workExpierences = (new WorkExpierence())
            ->select(['workexpierence.*', 'employer.name as employer_name', 'employer.office_location', 'employer.website'])
            ->leftjoin('employer', 'employer_id', '=', 'employer.id')
            ->orderBy('begin_year', 'ASC')
            ->get();

        return $this->view->render($response, 'workexpierence/index.twig', [
            'workExpierences' => $workExpierences,
        ]);
    }

    /**
     * Returns the edit function for
     *
     * @param \Psr\Http\Message\RequestInterface  $request
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return mixed
     * @throws \ReflectionException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function create(RequestInterface $request, ResponseInterface $response)
    {
        $this->authenticate();

        $employers = (new Employer())
                        ->select()
                        ->get();

        return $this->view->render($response, 'workexpierence/create.twig', [
            'employers' => $employers,
        ]);
    }

    /**
     * Stores the new work expierence.
     *
     * @param \Psr\Http\Message\RequestInterface  $request
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return mixed
     * @throws \ReflectionException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function store(RequestInterface $request, ResponseInterface $response)
    {
        $this->authenticate();

        $validator = (new Validator($request))->setRules([
                                                             'title'      => 'required|max:255',
                                                             'employer'   => 'required',
                                                             'begin_year' => 'required|lessthen:end_year',
                                                             'end_year'   => 'required',
                                                         ])
                                              ->validate();
        if ( ! $validator->validationPassed())
        {

            return $this->view->render($response, 'workexpierence/create.twig', [
                'errorTitle'       => Error::has('title') ? Error::get('title') : null,
                'errorDescription' => Error::has('errorDescription') ? Error::get('errorDescription') : null,
                'errorEmployer'    => Error::has('employer') ? Error::get('employer') : null,
                'errorBegindate'   => Error::has('begin_year') ? Error::get('begin_year') : null,
                'errorEnddate'     => Error::has('end_year') ? Error::get('end_year') : null,
            ]);
        }

        (new WorkExpierence())->insert([
                                           'name'        => $request->getParsedBody()['title'],
                                           'employee_id' => $request->getParsedBody()['employer'],
                                           'description' => $request->getParsedBody()['description'],
                                           'begin_year'  => $request->getParsedBody()['begin_year'],
                                           'end_year'    => $request->getParsedBody()['end_year'],
                                       ]);

        Error::clear();

        return redirect('workexpierence');
    }

    /**
     * Deletes a workexpierence.
     *
     * @param \Psr\Http\Message\RequestInterface  $request
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return string
     * @throws \ReflectionException
     */
    public function delete(RequestInterface $request, ResponseInterface $response)
    {
        $this->authenticate();

        (new WorkExpierence())->delete()
                              ->where('id', '=', $request->getQueryParams()['id'])
                              ->get();

        $response->getBody()->write((json_encode([
                                                            'status' => 'success'
                                                        ])));

        return $response;
    }
}