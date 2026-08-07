<?php

namespace App\Services;

use App\Models\Course;
use App\Models\CoursePrerequisite;
use Exception;

class CourseGraphService
{
    /**
     * Detects if adding a prerequisite will create a circular dependency.
     */
    public function detectCircularDependency(int $courseId, int $prerequisiteId): bool
    {
        if ($courseId === $prerequisiteId) {
            return true;
        }

        $visited = [];
        return $this->dfsCycleDetection($prerequisiteId, $courseId, $visited);
    }

    private function dfsCycleDetection(int $currentCourseId, int $targetCourseId, array &$visited): bool
    {
        if ($currentCourseId === $targetCourseId) {
            return true;
        }

        if (isset($visited[$currentCourseId])) {
            return false;
        }
        $visited[$currentCourseId] = true;

        $prerequisites = CoursePrerequisite::where('course_id', $currentCourseId)->get();

        foreach ($prerequisites as $prerequisite) {
            if ($this->dfsCycleDetection($prerequisite->prerequisite_course_id, $targetCourseId, $visited)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Generates a learning path for a given course using Topological Sort.
     */
    public function generateLearningPath(int $targetCourseId): array
    {
        $path = [];
        $visited = [];
        $visiting = [];

        $this->topologicalSort($targetCourseId, $visited, $visiting, $path);

        return $path;
    }

    private function topologicalSort(int $courseId, array &$visited, array &$visiting, array &$path): void
    {
        if (isset($visited[$courseId])) {
            return;
        }

        if (isset($visiting[$courseId])) {
            throw new Exception("Circular dependency detected during path generation.");
        }

        $visiting[$courseId] = true;

        $prerequisites = CoursePrerequisite::where('course_id', $courseId)->get();

        foreach ($prerequisites as $prerequisite) {
            $this->topologicalSort($prerequisite->prerequisite_course_id, $visited, $visiting, $path);
        }

        unset($visiting[$courseId]);
        $visited[$courseId] = true;
        
        $course = Course::find($courseId);
        if ($course) {
            $path[] = $course;
        }
    }
}
