<?php

namespace SocolaDaiCa\LaravelModulesCommand\Editor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use JsonException;
use ReflectionClass;
use SocolaDaiCa\LaravelAudit\Audit\AuditModel;
use SocolaDaiCa\LaravelAudit\Audit\AuditTable;

class Editor
{
    /**
     * @throws JsonException
     */
    public function modelAddMissingRelations(): void
    {
        $classes = AuditModel::getClassMap();
        $classes = array_keys($classes);
        $classes = collect($classes)
            ->filter(function ($class) {
                return Str::contains($class, '\Models\\');
            })
            ->filter(function ($class) {
                $reflectionClass = new ReflectionClass($class);

                return is_subclass_of($class, Model::class)
                    && !$reflectionClass->isAbstract()
                    && !$reflectionClass->isTrait()
                    && !$reflectionClass->isInterface();
            })
        ;

        $tableToModelClass = [];

        foreach ($classes as $class) {
            $table = (new $class())->getTable();
            $tableToModelClass[$table] = $class;
        }

        /** @var AuditModel[] $tableToAuditModels */
        $tableToAuditModels = [];
        /** @var AuditTable[] $tableToAuditTables */
        $tableToAuditTables = [];

        foreach ($tableToModelClass as $table => $modelClass) {
            $auditModelClass = AuditModel::makeByClass($modelClass);
            $tableToAuditModels[$table] = $auditModelClass;

            $auditTable = AuditTable::make($table);
            $tableToAuditTables[$table] = $auditTable;
        }

        $foreignKeys = collect([]);

        foreach ($tableToAuditModels as $table => $auditModel) {
            foreach (Schema::getForeignKeys($table) as $foreignKey) {
                $foreignKey['table'] = $table;
                $foreignKeys->push($foreignKey);
            }
        }

        foreach ($foreignKeys as $foreignKeyIndex1 => $foreignKey1) {
            // belongsTo
            $table1 = $foreignKey1['table'];
            $auditModel1 = $tableToAuditModels[$table1];
            $editorModel1 = EditorModel::openFile($auditModel1->reflectionClass->getFileName());
            $relations1 = Str::singular(Str::camel($foreignKey1['foreign_table']));

            if (!$auditModel1->reflectionClass->hasMethod($relations1)) {
                $editorModel1->addBelongsToRelation(
                    $relations1,
                    $tableToModelClass[$foreignKey1['foreign_table']],
                    $foreignKey1['columns'],
                    $foreignKey1['foreign_columns'],
                );
            }

            // hasMany
            $table2 = $foreignKey1['foreign_table'];
            $auditModel2 = $tableToAuditModels[$table2];
            $editorModel2 = EditorModel::openFile($auditModel2->reflectionClass->getFileName());
            $relations2 = Str::plural(Str::camel($foreignKey1['table']));

            if (
                !$auditModel2->reflectionClass->hasMethod($relations2)
                && !$tableToAuditTables[$table2]->isUnique($foreignKey1['columns'])
            ) {
                $editorModel2->addHasManyRelation(
                    $relations2,
                    $tableToModelClass[$foreignKey1['table']],
                    $foreignKey1['columns'],
                    $foreignKey1['foreign_columns'],
                );
            }

            // hasOne
            $relations2 = Str::singular(Str::camel($foreignKey1['table']));

            if (
                !$auditModel2->reflectionClass->hasMethod($relations2)
                //                && $tableToAuditTables[$table2]->isUnique($foreignKey1['columns'])
            ) {
                $editorModel2->addHasOneRelation(
                    $relations2,
                    $tableToModelClass[$foreignKey1['table']],
                    $foreignKey1['columns'],
                    $foreignKey1['foreign_columns'],
                );
            }

            //            foreach ($foreignKeys as $foreignKeyIndex2 => $foreignKey2) {
            //                if ($foreignKey1['table'] == $foreignKey2['table']) {
            //                    // belongsToMany
            //                    $relations3 = Str::plural(Str::camel($foreignKey2['foreign_table']));
            //
            ////                    Cannot redeclare SocolaDaiCa\Ncm\Models\TraRoute::masInputs()
            //
            //                    if (
            //                        $foreignKeyIndex1 != $foreignKeyIndex2
            //                        && !$auditModel1->reflectionClass->hasMethod($relations3)
            //                    ) {
            ////                        dd(
            ////                            $table1,
            ////                            $relations3,
            ////                            $foreignKey1,
            ////                            $foreignKey2,
            ////                        );
            //                        $editorModel1->addBelongsToManyRelation(
            //                            $relations3,
            //                            $tableToModelClass[$foreignKey2['foreign_table']],
            //                            $foreignKey1['columns'],
            //                            $foreignKey2['columns'],
            //                        );
            //                    }
            //                }
            //            }

            $editorModel1->save();
            $editorModel2->save();
        }
    }
}
