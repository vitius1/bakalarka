<?php 
$memo1="--- Final Memo Structure ---

Group 15: Card=8 (Max=10000, Min=0)

   1 PhyOp_Range 1 ASC   Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 0.0032908 (Distance = 2)


   0 LogOp_GetIdx (Distance = 1)



Root Group 14: Card=8 (Max=1e+08, Min=0)

   3 PhyOp_StreamGbAgg 9.5 13.0  Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 0.0230235 (Distance = 1)


   0 LogOp_GbAgg 9 13 (Distance = 0)



Group 13: 
   0 AncOp_PrjList  12.0  Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 0 (Distance = 0)



Group 12: 
   0 AncOp_PrjEl  11.0  Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 0 (Distance = 0)



Group 11: 
   0 ScaOp_AggFunc  10.0  Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 2 (Distance = 0)



Group 10: 
   0 ScaOp_Const   Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 1 (Distance = 0)



Group 9: Card=12.9333 (Max=1e+08, Min=0)

   5 PhyOp_LoopsJoinx_jtLeftOuter 7.5 8.3 4.0  Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 0.0230117 (Distance = 1)


   4 PhyOp_LoopsJoinx_jtLeftOuter 7.4 8.3 4.0  Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 0.011613 (Distance = 1)


   1 LogOp_RightOuterJoin 8 7 4 (Distance = 1)


   0 LogOp_LeftOuterJoin 7 8 4 (Distance = 0)



Group 8: Card=5 (Max=10000, Min=0)

   3 PhyOp_TableScan  Cost(RowGoal 0,ReW 9,ReB 0,Dist 0,Total 0)= 0.0040435 (Distance = 1)


   2 PhyOp_Range 1 ASC   Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 0.0032875 (Distance = 1)


   0 LogOp_Get (Distance = 0)



Group 7: Card=10 (Max=10000, Min=0)

   5 PhyOp_LoopsJoinx_jtLeftOuter 5.4 6.3 2.0  Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 0.0187442 (Distance = 1)


   4 PhyOp_LoopsJoinx_jtLeftOuter 5.2 6.3 2.0  Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 0.0073455 (Distance = 1)


   1 LogOp_RightOuterJoin 6 5 2 (Distance = 1)


   0 LogOp_LeftOuterJoin 5 6 2 (Distance = 0)



Group 6: Card=5 (Max=10000, Min=0)

   3 PhyOp_TableScan  Cost(RowGoal 0,ReW 7,ReB 0,Dist 0,Total 0)= 0.0038755 (Distance = 1)


   2 PhyOp_Range 1 ASC   Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 0.0032875 (Distance = 1)


   0 LogOp_Get (Distance = 0)



Group 5: Card=8 (Max=10000, Min=0)

   4 PhyOp_Sort 5.2  Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 0.0146895 (Distance = 0)


   2 PhyOp_Range 1 ASC   Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 0.0032908 (Distance = 1)


   0 LogOp_Get (Distance = 0)



Group 4: 
   0 ScaOp_Comp  0.0 3.0  Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 3 (Distance = 0)



Group 3: 
   0 ScaOp_Identifier   Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 1 (Distance = 0)



Group 2: 
   0 ScaOp_Comp  0.0 1.0  Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 3 (Distance = 0)



Group 1: 
   0 ScaOp_Identifier   Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 1 (Distance = 0)



Group 0: 
   0 ScaOp_Identifier   Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 1 (Distance = 0)



----------------------------



*** Output Tree: ***

        Exchange Start

        PhyOp_ExecutionModeAdapter(BatchToRow)

            PhyOp_HashJoinx_jtInner (batch)(QCOL: [o].id)
 = (QCOL: [z].idodd)


                PhyOp_Range TBL: oddeleni(alias TBL: o)(0) ASC  Bmk ( COL: Bmk1002 ) IsRow: COL: IsBaseRow1003 

                PhyOp_Range TBL: zamestnanec(alias TBL: z)(0) ASC  Bmk ( COL: Bmk1000 ) IsRow: COL: IsBaseRow1001 

                ScaOp_Comp x_cmpEq

                    ScaOp_Identifier QCOL: [o].id

                    ScaOp_Identifier QCOL: [z].idodd

********************

** Query marked as Cachable

********************

** Query cachability updated to FALSE

********************


(8 rows affected)

(1000000 rows affected)

Completion time: 2021-01-30T16:40:44.7181876+01:00
";
$tree1="

*** Output Tree: ***

        PhyOp_StreamGbAgg(  QCOL: [c].display_name) SORT-REQUEST(  QCOL: [c].display_name)

            PhyOp_LoopsJoin x_jtLeftOuter

                PhyOp_LoopsJoin x_jtLeftOuter

                    PhyOp_Sort +s -d QCOL: [c].display_name

                        PhyOp_Range TBL: contact(alias TBL: c)(1) ASC  Bmk ( QCOL: [c].id) IsRow: COL: IsBaseRow1000

                    PhyOp_TableScan TBL: relationship(alias TBL: r) Bmk ( id) IsRow: COL: IsBaseRow1001

                    ScaOp_Comp x_cmpEq

                        ScaOp_Identifier QCOL: [c].id

                        ScaOp_Identifier QCOL: [r].contact_id_a

                PhyOp_TableScan TBL: relationship(alias TBL: r2) Bmk ( id) IsRow: COL: IsBaseRow1002

                ScaOp_Comp x_cmpEq

                    ScaOp_Identifier QCOL: [c].id

                    ScaOp_Identifier QCOL: [r2].contact_id_b

            AncOp_PrjList

                AncOp_PrjEl COL: Expr1003

                    ScaOp_AggFunc stopCount Transformed

                        ScaOp_Const TI(int,ML=4) XVAR(int,Not Owned,Value=0)

********************

** Query marked as Cachable

********************


(8 rows affected)

Completion time: 2021-01-30T16:38:02.9061576+01:00
";

$memo2="--- Final Memo Structure ---

Group 6: Card=1e+06 (Max=1.1e+06, Min=0)

   0 LogOp_GetIdx (Distance = 1)



Root Group 5: Card=1e+06 (Max=1.1e+10, Min=0)

   6 PhyOp_HashJoinx_jtInner 4.4 3.4 2.0  Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 9.18975 (Distance = 2)


   5 PhyOp_ExecutionModeAdapter 5.6  Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 9.19875 (Distance = 0)


   2 PhyOp_HashJoinx_jtInner 4.2 3.2 2.0  Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 14.1742 (Distance = 2)


   1 LogOp_Join 4 3 2 (Distance = 1)


   0 LogOp_Join 3 4 2 (Distance = 0)



Group 4: Card=1000 (Max=10000, Min=0)

   5 PhyOp_ExecutionModeAdapter 4.2  Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 0.00962844 (Distance = 0)


   4 PhyOp_Range 0 ASC   Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 0.00882644 (Distance = 1)


   3 PhyOp_ExecutionModeAdapter 4.4  Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 0.00883044 (Distance = 0)


   2 PhyOp_Range 0 ASC   Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 0.00882644 (Distance = 1)


   0 LogOp_Get (Distance = 0)



Group 3: Card=1e+06 (Max=1.1e+06, Min=0)

   10 PhyOp_ExecutionModeAdapter 3.2  Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 7.49491 (Distance = 0)


   4 PhyOp_Range 0 ASC   Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 6.49291 (Distance = 1)


   3 PhyOp_ExecutionModeAdapter 3.4  Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 6.49791 (Distance = 0)


   2 PhyOp_Range 0 ASC   Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 6.49291 (Distance = 1)


   0 LogOp_Get (Distance = 0)



Group 2: 
   0 ScaOp_Comp  0.0 1.0  Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 3 (Distance = 0)



Group 1: 
   0 ScaOp_Identifier   Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 1 (Distance = 0)



Group 0: 
   0 ScaOp_Identifier   Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 1 (Distance = 0)



----------------------------

--- Final Memo Structure ---

Group 7: Card=1000 (Max=10000, Min=0)

   3 PhyOp_Range 0 ASC   Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 0.00777894 (Distance = 2)


   2 PhyOp_ExecutionModeAdapter 7.3  Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 0.0371275 (Distance = 0)


   1 PhyOp_Range 0 ASC   Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 0.0424137 (Distance = 2)


   0 LogOp_GetIdx (Distance = 1)



Group 6: Card=1e+06 (Max=1.1e+06, Min=0)

   0 LogOp_GetIdx (Distance = 1)



Root Group 5: Card=1e+06 (Max=1.1e+10, Min=0)

   11 PhyOp_HashJoinx_jtInner 4.9 3.14 2.0  Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 5.73881 (Distance = 2)


   10 PhyOp_ExecutionModeAdapter 5.11  Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 7.34606 (Distance = 0)


   6 PhyOp_HashJoinx_jtInner 4.4 3.4 2.0  Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 9.18975 (Distance = 2)


   5 PhyOp_ExecutionModeAdapter 5.6  Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 9.19875 (Distance = 0)


   2 PhyOp_HashJoinx_jtInner 4.2 3.2 2.0  Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 14.1742 (Distance = 2)


   1 LogOp_Join 4 3 2 (Distance = 1)


   0 LogOp_Join 3 4 2 (Distance = 0)



Group 4: Card=1000 (Max=10000, Min=0)

   14 PhyOp_TableScan  Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 0.00784436 (Distance = 1)


   13 PhyOp_ExecutionModeAdapter 4.14  Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 0.00797803 (Distance = 0)


   11 PhyOp_Sort 4.8  Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 0.0416121 (Distance = 0)


   9 PhyOp_Range 0 ASC   Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 0.00777894 (Distance = 1)


   8 PhyOp_ExecutionModeAdapter 4.9  Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 0.0371275 (Distance = 0)


   6 PhyOp_TableScan  Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 0.0371922 (Distance = 1)


   5 PhyOp_ExecutionModeAdapter 4.2  Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 0.00962844 (Distance = 0)


   4 PhyOp_Range 0 ASC   Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 0.00882644 (Distance = 1)


   3 PhyOp_ExecutionModeAdapter 4.4  Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 0.00883044 (Distance = 0)


   2 PhyOp_Range 0 ASC   Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 0.00882644 (Distance = 1)


   0 LogOp_Get (Distance = 0)



Group 3: Card=1e+06 (Max=1.1e+06, Min=0)

   19 PhyOp_TableScan  Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 5.57618 (Distance = 1)


   18 PhyOp_ExecutionModeAdapter 3.19  Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 5.74318 (Distance = 0)


   14 PhyOp_Range 0 ASC   Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 5.57611 (Distance = 1)


   13 PhyOp_ExecutionModeAdapter 3.14  Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 6.70632 (Distance = 0)


   11 PhyOp_TableScan  Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 6.70555 (Distance = 1)


   10 PhyOp_ExecutionModeAdapter 3.2  Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 7.49491 (Distance = 0)


   4 PhyOp_Range 0 ASC   Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 6.49291 (Distance = 1)


   3 PhyOp_ExecutionModeAdapter 3.4  Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 6.49791 (Distance = 0)


   2 PhyOp_Range 0 ASC   Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 6.49291 (Distance = 1)


   0 LogOp_Get (Distance = 0)



Group 2: 
   0 ScaOp_Comp  0.0 1.0  Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 3 (Distance = 0)



Group 1: 
   0 ScaOp_Identifier   Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 1 (Distance = 0)



Group 0: 
   0 ScaOp_Identifier   Cost(RowGoal 0,ReW 0,ReB 0,Dist 0,Total 0)= 1 (Distance = 0)



----------------------------


(1000000 rows affected)

Completion time: 2021-01-30T17:22:11.3936050+01:00
";
$tree2="

*** Output Tree: ***

        Exchange Start

        PhyOp_ExecutionModeAdapter(BatchToRow)

            PhyOp_HashJoinx_jtInner (batch)(QCOL: [o].id)
 = (QCOL: [z].idodd)


                PhyOp_Range TBL: oddeleni(alias TBL: o)(0) ASC  Bmk ( COL: Bmk1002 ) IsRow: COL: IsBaseRow1003 

                PhyOp_Range TBL: zamestnanec(alias TBL: z)(0) ASC  Bmk ( COL: Bmk1000 ) IsRow: COL: IsBaseRow1001 

                ScaOp_Comp x_cmpEq

                    ScaOp_Identifier QCOL: [o].id

                    ScaOp_Identifier QCOL: [z].idodd

********************

** Query marked as Cachable

********************

** Query cachability updated to FALSE

********************

";
 ?>