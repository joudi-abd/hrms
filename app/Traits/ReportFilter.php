<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait ReportFilter
{
    public function scopeApplyFilters(Builder $query, array $filters): Builder
    {
        // Date range
        if (!empty($filters['from'])) {
            $query->whereDate($this->getDateColumn(), '>=', $filters['from']);
        }

        if (!empty($filters['to'])) {
            $query->whereDate($this->getDateColumn(), '<=', $filters['to']);
        }

        // Status
        if (!empty($filters['status'])) {
            $this->applyStatusFilter($query, $filters['status']);
        }

        // Department
        if (!empty($filters['department_id']) && $this->hasColumn('department_id')) {
            $query->where('department_id', $filters['department_id']);
        }

        // Employee
        if (!empty($filters['employee_id'])) {
            $query->where($this->getEmployeeColumn(), $filters['employee_id']);
        }

        return $query;
    }

    /* ====== Helpers ====== */

    protected function getEmployeeColumn(): string
    {
        return 'employee_id';
    }

    protected function getDateColumn(): string
    {
        return 'created_at';
    }

    protected function applyStatusFilter(Builder $query, string $status): void
    {
        $query->where('status', $status);
    }



    protected function hasColumn(string $column): bool
    {
        return \Schema::hasColumn($this->getTable(), $column);
    }
}