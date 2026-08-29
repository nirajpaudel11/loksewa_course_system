<?php

namespace App\Services;

use App\Models\Course;
use App\Models\CoursePrerequisite;
use App\Services\Algorithms\Graph\DependencyGraph;
use App\Services\Algorithms\Graph\TopologicalSort;
use Exception;

class CourseDependencyService
{
    /**
     * Builds the dependency graph from the database.
     */
    public function buildGraph(): DependencyGraph
    {
        $graph = new DependencyGraph;

        // Add all courses as isolated nodes initially to ensure even courses without dependencies exist in graph
        $courseIds = Course::pluck('id')->toArray();
        foreach ($courseIds as $id) {
            $graph->addNode($id);
        }

        $prerequisites = CoursePrerequisite::all();

        foreach ($prerequisites as $prereq) {
            // Edge direction: Prerequisite -> Dependent Course
            $graph->addEdge($prereq->prerequisite_course_id, $prereq->course_id);
        }

        return $graph;
    }

    /**
     * Validates if the current prerequisite structure is a valid DAG (no circular dependencies).
     */
    public function validatePrerequisites(): bool
    {
        $graph = $this->buildGraph();

        try {
            TopologicalSort::sort($graph);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Returns the strict sequential order in which courses must be learned based on prerequisites.
     */
    public function getLearningOrder(): array
    {
        $graph = $this->buildGraph();

        return TopologicalSort::sort($graph);
    }

    /**
     * Checks if a student is eligible to unlock a specific course based on their completed courses.
     */
    public function canUnlockCourse(int $targetCourseId, array $completedCourseIds): bool
    {
        $prerequisites = CoursePrerequisite::where('course_id', $targetCourseId)->pluck('prerequisite_course_id')->toArray();

        foreach ($prerequisites as $prereqId) {
            if (! in_array($prereqId, $completedCourseIds)) {
                return false; // Missing a prerequisite
            }
        }

        return true;
    }
}
