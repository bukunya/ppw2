<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JobVacancy;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class JobApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/jobs",
     *     summary="Get all job listings",
     *     tags={"Jobs"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of jobs",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="title", type="string"),
     *                 @OA\Property(property="company", type="string"),
     *                 @OA\Property(property="location", type="string")
     *             )
     *         )
     *     )
     * )
     */
    public function index(Request $req)
    {
        $q = JobVacancy::query();

        if ($req->filled('keyword')) {
            $kw = $req->keyword;
            $q->where(function($s) use ($kw) {
                $s->where('title', 'like', "%$kw%")
                  ->orWhere('company', 'like', "%$kw%")
                  ->orWhere('location', 'like', "%$kw%");
            });
        }

        if ($req->filled('company')) {
            $q->where('company', 'like', '%' . $req->company . '%');
        }

        if ($req->filled('location')) {
            $q->where('location', 'like', '%' . $req->location . '%');
        }

        $jobs = $q->orderBy('created_at', 'desc')->paginate($req->get('per_page', 10));

        return response()->json($jobs);
    }

    public function show(JobVacancy $jobVacancy)
    {
        return response()->json($jobVacancy);
    }

    public function store(Request $req)
    {
        if ($req->user()->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $data = $req->validate([
            'title' => 'required',
            'description' => 'required',
            'location' => 'required',
            'company' => 'required',
            'salary' => 'nullable|integer',
        ]);

        $job = JobVacancy::create($data);

        return response()->json(['message' => 'Created', 'job' => $job], 201);
    }

    public function update(Request $req, JobVacancy $jobVacancy)
    {
        if ($req->user()->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $data = $req->validate([
            'title' => 'sometimes|required',
            'description' => 'sometimes|required',
            'location' => 'sometimes|required',
            'company' => 'sometimes|required',
            'salary' => 'nullable|integer',
        ]);

        $jobVacancy->update($data);

        return response()->json(['message' => 'Updated', 'job' => $jobVacancy]);
    }

    public function destroy(Request $req, JobVacancy $jobVacancy)
    {
        if ($req->user()->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $jobVacancy->delete();

        return response()->json(['message' => 'Deleted']);
    }

    public function publicIndex()
    {
        $jobs = JobVacancy::orderBy('created_at', 'desc')->paginate(10);

        return response()->json($jobs);
    }
}
