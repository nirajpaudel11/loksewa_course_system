<?php

namespace App\Services\Algorithms\Graph;

use Exception;

class TopologicalSort
{
    /**
     * Performs topological sorting using Kahn's Algorithm (BFS).
     * Returns an array of node IDs in topological order.
     * Throws an Exception if a cycle is detected (Invalid DAG).
     */
    public static function sort(DependencyGraph $graph): array
    {
        $inDegrees = $graph->getInDegrees();
        $adjList = $graph->getAdjacencyList();
        
        $queue = [];
        $order = [];
        $visitedCount = 0;
        $totalNodes = count($adjList);

        // Enqueue nodes with 0 in-degree (no prerequisites)
        foreach ($inDegrees as $node => $degree) {
            if ($degree === 0) {
                $queue[] = $node;
            }
        }

        while (!empty($queue)) {
            $u = array_shift($queue);
            $order[] = $u;
            $visitedCount++;

            foreach ($adjList[$u] as $v) {
                $inDegrees[$v]--;
                
                if ($inDegrees[$v] === 0) {
                    $queue[] = $v;
                }
            }
        }

        // If visited count != total nodes, there is a cycle
        if ($visitedCount !== $totalNodes) {
            throw new Exception("Cycle detected in course prerequisites! The learning path is impossible.");
        }

        return $order;
    }
}
