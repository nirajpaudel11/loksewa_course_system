<?php

namespace App\Services\Algorithms\Graph;

class DependencyGraph
{
    private array $adjacencyList = [];

    private array $inDegrees = [];

    /**
     * Add a node (Course ID) to the graph.
     */
    public function addNode(int $courseId): void
    {
        if (! isset($this->adjacencyList[$courseId])) {
            $this->adjacencyList[$courseId] = [];
            $this->inDegrees[$courseId] = 0;
        }
    }

    /**
     * Add a directed edge from prerequisite to dependent course.
     * U -> V (U must be completed before V)
     */
    public function addEdge(int $prerequisiteId, int $courseId): void
    {
        $this->addNode($prerequisiteId);
        $this->addNode($courseId);

        if (! in_array($courseId, $this->adjacencyList[$prerequisiteId])) {
            $this->adjacencyList[$prerequisiteId][] = $courseId;
            $this->inDegrees[$courseId]++;
        }
    }

    public function getAdjacencyList(): array
    {
        return $this->adjacencyList;
    }

    public function getInDegrees(): array
    {
        return $this->inDegrees;
    }
}
