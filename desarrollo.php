<?php

public function createVersionSettlement(Request $request)
    {

        try {

            $req = $request->all();
            $comodin = '';
            $event_id = isset($req['event_id']) ? $req['event_id'] : '';
            $reservation = isset($req['reservation']) ? $req['reservation'] : '';
            $department = isset($req['department']) ? $req['department'] : '';
            $additional = isset($req['additional']) ? $req['additional'] : '';
            $user_id = isset($req['user_id']) ? $req['user_id'] : '';
            $products_request = isset($req['products']) ? $req['products'] : '';

            $products = json_decode(json_encode($products_request));

            $object_reservation = $this->getReservation($reservation['id']);

            $reservation_id = $reservation['id'];

            //$res_settlement = $this->insertSettlement($reservation_id, $event_id, $user_id);

            $rese_codi = $object_reservation->id_reserva_newplan;

            $rese_anci = $reservation['yearIni'];

            $user = $this->generic->getUser($user_id);

            $res_settlement = DB::select(DB::raw('SELECT id_liquidacion FROM cliente_1."Liquidacion" WHERE id_reserva_interna = ' . $reservation['id'] . ' AND id_estado = 3 ORDER BY fecha_creacion DESC LIMIT 1'));

            if ($res_settlement) {

                $settlement_id_before = $res_settlement[0]->id_liquidacion;

                $products_before = $this->generic->getProductsBefore($settlement_id_before);

                if (!empty($reservation_id) && !empty($products_request)) {

                    $settlement_id = DB::table('Liquidacion')->insertGetId([
                        'id_departamento_servicio' => $department['id'],
                        'id_reserva_interna' => $reservation_id,
                        'id_estado' => 3,
                        'fecha_liquidacion' => now(),
                        'id_tipo_adicional' => isset($additional['id']) ? $additional['id'] : 0,
                        'nombre_departamento_servicio' => $department['name'],
                        'nombre_tipo_adicional' => isset($additional['name']) ? $additional['name'] : '',
                        'estado_solicitudes_terceros' => 0,
                        'user_creacion' => $user_id,
                        'fecha_creacion' => now(),
                        'user_ult_modif' => $user_id,
                        'fecha_ult_modif' => now()
                    ], 'id_liquidacion');

                    if ($settlement_id) {

                        $products_briefcase = array();
                        $products_hijos = array();

                        $products_third = array();

                        foreach ($products as  $product) {
                            if (isset($product->third_id)) {

                                if (isset($product->id_padre) && $product->id_padre != 0) {
                                    array_push($products_hijos, $product);
                                } else {
                                    array_push($products_third, $product);
                                }
                            } else {

                                array_push($products_briefcase, $product);
                            }
                        }

                        if (count($products_third) > 0) {

                            foreach ($products_third as $product) {
                                $nuevo = false;
                                if (isset($product->id)) {
                                    $product->code_pdto_newplan = $product->id;
                                }
                                if (!isset($product->settlement_detail_id)) {
                                    $product->settlement_detail_id = $this->save_product($product, $settlement_id, $user_id, true);
                                    if ($product->type == 1) {
                                        $product->code_pdto_newplan = 0;
                                    }
                                    $nuevo = true;
                                    // $this->generateRequestVersion($product, $settlement_id, $product->settlement_detail_id, $user_id);
                                }

                                $is_other = 'N';


                                $sql = 'SELECT count(dl.*) count
                                        FROM   cliente_1."DetalleLiquidacion" AS dl
                                            INNER JOIN cliente_1."Liquidacion" AS l
                                                    ON l.id_liquidacion = dl.id_liquidacion
                                            INNER JOIN cliente_1."Reserva" AS r
                                                    ON r.id_reserva_interna = l.id_reserva_interna
                                        WHERE  r.id_reserva_interna = ' . $reservation_id . '
                                            AND dl.id_item = \'' . $product->code_pdto_newplan . '\'
                                            AND dl.is_gestionada = 1';

                                if ($product->type == 1 && isset($product->settlement_detail_id)) {
                                    $sql = $sql . ' AND dl.id_detalle_liquidacion = ' . $product->settlement_detail_id;
                                }

                                $result = DB::select(DB::raw($sql));

                                if ($nuevo) {
                                    //$this->insertRequestVersion($product, $settlement_id, $user_id, 1);
                                    $result = false;
                                }

                                $department = $this->departmentId($product->dpto_code_newplan);

                                $typeAdditional  = '';

                                if (isset($product->type_code_newplan)) {

                                    $typeAdditional = $this->typeAdditionalId($product->type_code_newplan);
                                }

                                if (!empty($department)) {

                                    $type_id = 0;

                                    if (!empty($typeAdditional)) {

                                        $type_id = $typeAdditional->id_tipo_adicional;
                                    }

                                    if (isset($product->id)) {

                                        $product->code_pdto_newplan = $product->id;
                                    }
                                    $settlement_detail_id = isset($product->settlement_detail_id) ? $product->settlement_detail_id : 0;
                                    $product_exist = DB::select(DB::raw('SELECT * FROM cliente_1."DetalleLiquidacion" WHERE id_liquidacion =' . $settlement_id_before . ' AND id_detalle_liquidacion = ' . $settlement_detail_id));
                                    $product_rcnt = DB::select(DB::raw('SELECT * FROM cliente_1."DetalleLiquidacion" WHERE id_liquidacion =' . $settlement_id . ' AND id_detalle_liquidacion = ' . $settlement_detail_id));
                                    if ($product_rcnt) {
                                    } else if ($product_exist) {
                                        if ($product->code_pdto_newplan == 0) {
                                            $comodin = 1;
                                        } else {
                                            $comodin = 0;
                                        }
                                        $id_settlemen_detail = DB::table('DetalleLiquidacion')->insertGetId([
                                            'cantidad_adultos' => isset($product->q_adult) ? $product->q_adult : 0,
                                            'cantidad_niños' => isset($product->q_child) ? $product->q_child : 0,
                                            'forma_calculo_id' => $product->f_cal,
                                            'es_otros_servicios' => $is_other,
                                            'id_item' => $product->code_pdto_newplan,
                                            'id_liquidacion' => $settlement_id,
                                            'id_unidad_otros_servicios' => isset($product->third_id) ? $product->third_id : 0,
                                            'cantidad' => isset($product->q_unit) ? $product->q_unit : 0,
                                            'valor_adulto' => (int) isset($product->v_adult) ? $product->v_adult : 0,
                                            'valor_niño' => (int) isset($product->v_child) ? $product->v_child : 0,
                                            'valor_unitario' => (int) isset($product->v_unit) ? $product->v_unit : 0,
                                            'porcen_imp' => $product_exist[0]->porcen_imp,
                                            'descripcion_item' => isset($product->name) ? $product->name : '',
                                            'descripcion_unid_otr_serv' => isset($product->name_third) ? $product->name_third : '',
                                            'id_departamento_servicio' => $department->id_departamento,
                                            'id_tipo_adicional' => $type_id,
                                            'observacion_item' => isset($product->observation) ? $product->observation : '',
                                            'total' => $product->total,
                                            'active' => 1,
                                            'numero_bebes' => isset($product->q_bebes) ? $product->q_bebes : 0,
                                            'rango_edad_bebes' => isset($product->r_bebes) ? $product->r_bebes : '',
                                            'numero_niños' => isset($product->q_niños) ? $product->q_niños : 0,
                                            'rango_edad_niños' => isset($product->r_niños) ? $product->r_niños : '',
                                            'numero_jovenes' => isset($product->q_jovenes) ? $product->q_jovenes : 0,
                                            'rango_edad_jovenes' => isset($product->r_jovenes) ? $product->r_jovenes : '',
                                            'numero_adultos' => isset($product->q_adultos) ? $product->q_adultos : 0,
                                            'rango_edad_adultos' => isset($product->r_adultos) ? $product->r_adultos : '',
                                            'numero_tercera_edad' => isset($product->q_tercera_edad) ? $product->q_tercera_edad : 0,
                                            'rango_edad_tercera_edad' => isset($product->r_tercera_edad) ? $product->r_tercera_edad : '',
                                            'numero_discapacidad' => isset($product->q_discapacidad) ? $product->q_discapacidad : 0,
                                            'rango_edad_personas_discapacidad' => isset($product->r_discapacidad) ? $product->r_discapacidad : '',
                                            'presupuesto_plan_aliado' => isset($product->pp_aliado) ? $product->pp_aliado : 0,
                                            'presupuesto_plan_aliado_venta' => isset($product->pp_aliado_venta) ? $product->pp_aliado_venta : 0,
                                            'presupuesto_venta' => isset($product->venta) ? $product->venta : 0,
                                            'modalidad' => isset($product->modalidad) ? $product->modalidad : 1,
                                            'valor_sin_impuesto_unidad' => $product_exist[0]->valor_sin_impuesto_unidad,
                                            'valor_sin_impuesto_adultos' => $product_exist[0]->valor_sin_impuesto_adultos,
                                            'valor_sin_impuesto_niños' => $product_exist[0]->valor_sin_impuesto_niños,
                                            'valor_con_impuesto_unidad' => $product_exist[0]->valor_con_impuesto_unidad,
                                            'valor_con_impuesto_adultos' => $product_exist[0]->valor_con_impuesto_adultos,
                                            'valor_con_impuesto_niños' => $product_exist[0]->valor_con_impuesto_niños,
                                            'impuesto' => $product_exist[0]->impuesto,
                                            'is_gestionada' => $product_exist[0]->is_gestionada,
                                            'valor_checklist' => $product_exist[0]->valor_checklist,
                                            'fee_unitario' => $product_exist[0]->fee_unitario,
                                            'fee_adulto' => $product_exist[0]->fee_adulto,
                                            'fee_niño' => $product_exist[0]->fee_niño,
                                            'user_creacion' => $user_id,
                                            'fecha_creacion' => now(),
                                            'user_ult_modif' => $user_id,
                                            'fecha_ult_modif' => now(),
                                            'detalle_item' => $product->d_item,
                                            'comodin' => $comodin,
                                            'padre' => isset($product->padre) ? $product->padre : 0,
                                            'descripcion_item_ues' => isset($product->name) ? $product->name : '',
                                            'cantidad_ues' => isset($product->q_unit) ? $product->q_unit : 0,
                                            'cantidad_adultos_ues' => isset($product->q_adult) ? $product->q_adult : 0,
                                            'cantidad_niños_ues' => isset($product->q_child) ? $product->q_child : 0,
                                            'valor_adulto_ues' => (int) isset($product->v_adult) ? $product->v_adult : 0,
                                            'valor_niño_ues' => (int) isset($product->v_child) ? $product->v_child : 0,
                                            'valor_unitario_ues' => (int) isset($product->v_unit) ? $product->v_unit : 0,
                                            'id_categoria' => (int)isset($product->id_categoria) ? $product->id_categoria : 0,
                                            'valor_con_impuesto_unidad_ues' => (int) isset($product->v_total_unit) ? $product->v_total_unit : 0,
                                            'valor_con_impuesto_adultos_ues' => (int) isset($product->v_total_adult) ? $product->v_total_adult : 0,
                                            'valor_con_impuesto_niños_ues' => (int) isset($product->v_total_child) ? $product->v_total_child : 0,
                                            'id_detalle_liquidacion_orig' => $product_exist[0]->id_detalle_liquidacion_orig,
                                            'id_tipo_programa' => (int) isset($product->tipoprograma) ? $product->tipoprograma : 0,
                                        ], 'id_detalle_liquidacion');
                                        $this->carryDetails($product->settlement_detail_id, $id_settlemen_detail);
                                        if (isset($product->scomplejidades)) {
                                            $this->relComplejidad($product->scomplejidades, $id_settlemen_detail);
                                        }
                                        $this->generateRequestVersion($product, $settlement_id, $id_settlemen_detail, $user_id);
                                    } else {
                                        $id_settlemen_detail = $this->insertNewDetail($product, $is_other, $settlement_id, $department, $type_id, $user_id);
                                        $this->generateRequestVersion($product, $settlement_id, $id_settlemen_detail, $user_id);
                                    }

                                    if (isset($product->padre) && $product->padre == 1) {
                                        foreach ($products_hijos as $hijo) {
                                            if ($hijo->id_padre == $product->settlement_detail_id) {
                                                if ($hijo->code_pdto_newplan == 0) {
                                                    $comodin = 1;
                                                } else {
                                                    $comodin = 0;
                                                }
                                                $product_exist = DB::select(DB::raw('SELECT * FROM cliente_1."DetalleLiquidacion" WHERE id_liquidacion =' . $settlement_id_before . ' AND id_detalle_liquidacion = ' . $hijo->settlement_detail_id));
                                                $id_settlement_hijo = DB::table('DetalleLiquidacion')->insertGetId([
                                                    'cantidad_adultos' => isset($hijo->q_adult) ? $hijo->q_adult : 0,
                                                    'cantidad_niños' => isset($hijo->q_child) ? $hijo->q_child : 0,
                                                    'forma_calculo_id' => $hijo->f_cal,
                                                    'es_otros_servicios' => $is_other,
                                                    'id_item' => $hijo->code_pdto_newplan,
                                                    'id_liquidacion' => $settlement_id,
                                                    'id_unidad_otros_servicios' => isset($hijo->third_id) ? $hijo->third_id : 0,
                                                    'cantidad' => isset($hijo->q_unit) ? $hijo->q_unit : 0,
                                                    'valor_adulto' => (int) isset($hijo->v_adult) ? $hijo->v_adult : 0,
                                                    'valor_niño' => (int) isset($hijo->v_child) ? $hijo->v_child : 0,
                                                    'valor_unitario' => (int) isset($hijo->v_unit) ? $hijo->v_unit : 0,
                                                    'porcen_imp' => 0,
                                                    'descripcion_item' => isset($hijo->name) ? $hijo->name : '',
                                                    'descripcion_unid_otr_serv' => isset($hijo->name_third) ? $hijo->name_third : '',
                                                    'id_departamento_servicio' => $department->id_departamento,
                                                    'id_tipo_adicional' => $type_id,
                                                    'observacion_item' => isset($hijo->observation) ? $hijo->observation : '',
                                                    'total' => $hijo->total,
                                                    'active' => 1,
                                                    'numero_bebes' => isset($hijo->q_bebes) ? $hijo->q_bebes : 0,
                                                    'rango_edad_bebes' => isset($hijo->r_bebes) ? $hijo->r_bebes : '',
                                                    'numero_niños' => isset($hijo->q_niños) ? $hijo->q_niños : 0,
                                                    'rango_edad_niños' => isset($hijo->r_niños) ? $hijo->r_niños : '',
                                                    'numero_jovenes' => isset($hijo->q_jovenes) ? $hijo->q_jovenes : 0,
                                                    'rango_edad_jovenes' => isset($hijo->r_jovenes) ? $hijo->r_jovenes : '',
                                                    'numero_adultos' => isset($hijo->q_adultos) ? $hijo->q_adultos : 0,
                                                    'rango_edad_adultos' => isset($hijo->r_adultos) ? $hijo->r_adultos : '',
                                                    'numero_tercera_edad' => isset($hijo->q_tercera_edad) ? $hijo->q_tercera_edad : 0,
                                                    'rango_edad_tercera_edad' => isset($hijo->r_tercera_edad) ? $hijo->r_tercera_edad : '',
                                                    'numero_discapacidad' => isset($hijo->q_discapacidad) ? $hijo->q_discapacidad : 0,
                                                    'rango_edad_personas_discapacidad' => isset($hijo->r_discapacidad) ? $hijo->r_discapacidad : '',
                                                    'presupuesto_plan_aliado' => isset($hijo->pp_aliado) ? $hijo->pp_aliado : 0,
                                                    'presupuesto_plan_aliado_venta' => isset($hijo->pp_aliado_venta) ? $hijo->pp_aliado_venta : 0,
                                                    'presupuesto_venta' => isset($hijo->venta) ? $hijo->venta : 0,
                                                    'modalidad' => isset($hijo->modalidad) ? $hijo->modalidad : 1,
                                                    'valor_sin_impuesto_unidad' => $product_exist[0]->valor_sin_impuesto_unidad,
                                                    'valor_sin_impuesto_adultos' => $product_exist[0]->valor_sin_impuesto_adultos,
                                                    'valor_sin_impuesto_niños' => $product_exist[0]->valor_sin_impuesto_niños,
                                                    'valor_con_impuesto_unidad' => $product_exist[0]->valor_con_impuesto_unidad,
                                                    'valor_con_impuesto_adultos' => $product_exist[0]->valor_con_impuesto_adultos,
                                                    'valor_con_impuesto_niños' => $product_exist[0]->valor_con_impuesto_niños,
                                                    'impuesto' => $product_exist[0]->impuesto,
                                                    'is_gestionada' => $product_exist[0]->is_gestionada,
                                                    'valor_checklist' => $product_exist[0]->valor_checklist,
                                                    'fee_unitario' => $product_exist[0]->fee_unitario,
                                                    'fee_adulto' => $product_exist[0]->fee_adulto,
                                                    'fee_niño' => $product_exist[0]->fee_niño,
                                                    'user_creacion' => $user_id,
                                                    'fecha_creacion' => now(),
                                                    'user_ult_modif' => $user_id,
                                                    'fecha_ult_modif' => now(),
                                                    'detalle_item' => $hijo->d_item,
                                                    'comodin' => $comodin,
                                                    'id_padre' => $id_settlemen_detail,
                                                    'descripcion_item_ues' => isset($hijo->name) ? $hijo->name : '',
                                                    'cantidad_ues' => isset($hijo->q_unit) ? $hijo->q_unit : 0,
                                                    'cantidad_adultos_ues' => isset($hijo->q_adult) ? $hijo->q_adult : 0,
                                                    'cantidad_niños_ues' => isset($hijo->q_child) ? $hijo->q_child : 0,
                                                    'valor_adulto_ues' => (int) isset($hijo->v_adult) ? $hijo->v_adult : 0,
                                                    'valor_niño_ues' => (int) isset($hijo->v_child) ? $hijo->v_child : 0,
                                                    'valor_unitario_ues' => (int) isset($hijo->v_unit) ? $hijo->v_unit : 0,
                                                    'id_categoria' => (int)isset($hijo->id_categoria) ? $hijo->id_categoria : 0,
                                                    'valor_con_impuesto_unidad_ues' => (int) isset($hijo->v_total_unit) ? $hijo->v_total_unit : 0,
                                                    'valor_con_impuesto_adultos_ues' => (int) isset($hijo->v_total_adult) ? $hijo->v_total_adult : 0,
                                                    'valor_con_impuesto_niños_ues' => (int) isset($hijo->v_total_child) ? $hijo->v_total_child : 0,
                                                    'id_tipo_programa' => (int) isset($product->tipoprograma) ? $product->tipoprograma : 0,
                                                ], 'id_detalle_liquidacion');
                                                $this->carryDetails($hijo->settlement_detail_id, $id_settlement_hijo);
                                                if (isset($product->scomplejidades)) {
                                                    $this->relComplejidad($product->scomplejidades, $id_settlement_hijo);
                                                }
                                                $this->generateRequestVersion($hijo, $settlement_id, $id_settlement_hijo, $user_id);
                                            }
                                        }
                                    }

                                    if (!$nuevo) {
                                        if ($result) {

                                            if ($result[0]->count == 0) {

                                                if (isset($product->other) && $product->other == 'true') {

                                                    $is_other = 'S';

                                                    //$this->insertRequestVersion($product, $settlement_id, $user_id);
                                                } else if (isset($product->third_id) && $product->third_id > 0 || $product->type == 1) {

                                                    //$this->insertRequestVersion($product, $settlement_id, $user_id);
                                                }
                                            }
                                        } else {

                                            if (isset($product->other) && $product->other == 'true') {

                                                $is_other = 'S';

                                                //$this->insertRequestVersion($product, $settlement_id, $user_id);
                                            } else if (isset($product->third_id) && $product->third_id > 0 || $product->type == 1) {

                                                //$this->insertRequestVersion($product, $settlement_id, $user_id);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        if (count($products_briefcase) > 0) {

                            foreach ($products_briefcase as $product) {

                                $is_other = 'N';

                                $department = $this->departmentId($product->dpto_code_newplan);

                                $typeAdditional  = '';

                                if (isset($product->type_code_newplan)) {

                                    $typeAdditional = $this->typeAdditionalId($product->type_code_newplan);
                                }

                                if (!empty($department)) {

                                    $type_id = 0;

                                    if (!empty($typeAdditional)) {

                                        $type_id = $typeAdditional->id_tipo_adicional;
                                    }

                                    if (isset($product->id)) {

                                        $product->code_pdto_newplan = $product->id;
                                    }

                                    $sql = 'SELECT * FROM cliente_1."DetalleLiquidacion" WHERE id_item = ' . "'" . $product->code_pdto_newplan . "'" . ' AND id_liquidacion =' . $settlement_id_before;

                                    $product_exist = DB::select(DB::raw('SELECT * FROM cliente_1."DetalleLiquidacion" WHERE id_item = ' . "'" . $product->code_pdto_newplan . "'" . ' AND id_liquidacion =' . $settlement_id_before));

                                    if ($product_exist) {
                                        DB::table('DetalleLiquidacion')->insert([
                                            'cantidad_adultos' => isset($product->q_adult) ? $product->q_adult : 0,
                                            'cantidad_niños' => isset($product->q_child) ? $product->q_child : 0,
                                            'forma_calculo_id' => $product->f_cal,
                                            'es_otros_servicios' => $is_other,
                                            'id_item' => $product->code_pdto_newplan,
                                            'id_liquidacion' => $settlement_id,
                                            'id_unidad_otros_servicios' => isset($product->third_id) ? $product->third_id : 0,
                                            'cantidad' => isset($product->q_unit) ? $product->q_unit : 0,
                                            'valor_adulto' => (int) isset($product->v_adult) ? $product->v_adult : 0,
                                            'valor_niño' => (int) isset($product->v_child) ? $product->v_child : 0,
                                            'valor_unitario' => (int) isset($product->v_unit) ? $product->v_unit : 0,
                                            'porcen_imp' => $product_exist[0]->porcen_imp,
                                            'observacion_item' => isset($product->observation) ? $product->observation : '',
                                            'descripcion_item' => isset($product->name) ? $product->name : '',
                                            'descripcion_unid_otr_serv' => isset($product->name_third) ? $product->name_third : '',
                                            'id_departamento_servicio' => $department->id_departamento,
                                            'id_tipo_adicional' => $type_id,
                                            'total' => $product->total,
                                            'active' => 1,
                                            'numero_bebes' => isset($product->q_bebes) ? $product->q_bebes : 0,
                                            'rango_edad_bebes' => isset($product->r_bebes) ? $product->r_bebes : '',
                                            'numero_niños' => isset($product->q_niños) ? $product->q_niños : 0,
                                            'rango_edad_niños' => isset($product->r_niños) ? $product->r_niños : '',
                                            'numero_jovenes' => isset($product->q_jovenes) ? $product->q_jovenes : 0,
                                            'rango_edad_jovenes' => isset($product->r_jovenes) ? $product->r_jovenes : '',
                                            'numero_adultos' => isset($product->q_adultos) ? $product->q_adultos : 0,
                                            'rango_edad_adultos' => isset($product->r_adultos) ? $product->r_adultos : '',
                                            'numero_tercera_edad' => isset($product->q_tercera_edad) ? $product->q_tercera_edad : 0,
                                            'rango_edad_tercera_edad' => isset($product->r_tercera_edad) ? $product->r_tercera_edad : '',
                                            'numero_discapacidad' => isset($product->q_discapacidad) ? $product->q_discapacidad : 0,
                                            'rango_edad_personas_discapacidad' => isset($product->r_discapacidad) ? $product->r_discapacidad : '',
                                            'presupuesto_plan_aliado' => isset($product->pp_aliado) ? $product->pp_aliado : 0,
                                            'presupuesto_plan_aliado_venta' => isset($product->pp_aliado_venta) ? $product->pp_aliado_venta : 0,
                                            'presupuesto_venta' => isset($product->venta) ? $product->venta : 0,
                                            'modalidad' => isset($product->modalidad) ? $product->modalidad : 1,
                                            'valor_sin_impuesto_unidad' => $product_exist[0]->valor_sin_impuesto_unidad,
                                            'valor_sin_impuesto_adultos' => $product_exist[0]->valor_sin_impuesto_adultos,
                                            'valor_sin_impuesto_niños' => $product_exist[0]->valor_sin_impuesto_niños,
                                            'valor_con_impuesto_unidad' => $product_exist[0]->valor_con_impuesto_unidad,
                                            'valor_con_impuesto_adultos' => $product_exist[0]->valor_con_impuesto_adultos,
                                            'valor_con_impuesto_niños' => $product_exist[0]->valor_con_impuesto_niños,
                                            'impuesto' => $product_exist[0]->impuesto,
                                            'is_gestionada' => $product_exist[0]->is_gestionada,
                                            'valor_checklist' => $product_exist[0]->valor_checklist,
                                            'fee_unitario' => $product_exist[0]->fee_unitario,
                                            'fee_adulto' => $product_exist[0]->fee_adulto,
                                            'fee_niño' => $product_exist[0]->fee_niño,
                                            'user_creacion' => $user_id,
                                            'fecha_creacion' => now(),
                                            'user_ult_modif' => $user_id,
                                            'fecha_ult_modif' => now(),
                                            'descripcion_item_ues' => isset($product->name) ? $product->name : '',
                                            'cantidad_ues' => isset($product->q_unit) ? $product->q_unit : 0,
                                            'cantidad_adultos_ues' => isset($product->q_adult) ? $product->q_adult : 0,
                                            'cantidad_niños_ues' => isset($product->q_child) ? $product->q_child : 0,
                                            'valor_adulto_ues' => (int) isset($product->v_adult) ? $product->v_adult : 0,
                                            'valor_niño_ues' => (int) isset($product->v_child) ? $product->v_child : 0,
                                            'valor_unitario_ues' => (int) isset($product->v_unit) ? $product->v_unit : 0,
                                            'id_tipo_programa' => (int) isset($product->tipoprograma) ? $product->tipoprograma : 0,
                                        ]);
                                    } else {
                                        // settlement_id es la nueva liquidacion que crea 216
                                        $this->insertNewDetail($product, $is_other, $settlement_id, $department, $type_id, $user_id);
                                    }
                                }
                            }
                        }
                        $this->updateReservation($reservation_id, $event_id, $settlement_id, $user_id);

                        $this->insertNewPlanRead($rese_anci, $rese_codi, $object_reservation, $products_request, $products_before, $user);

                        return response()->json([
                            'status' => true,
                            'briefcase' => $products_briefcase,
                            'notBrief' => $products_third,
                            'productos' => $products,
                        ], 200);
                    }
                } else {

                    if (empty($reservation_id)) {

                        return response()->json([
                            'error' => 'No se envio la reserva'
                        ], 400);
                    } else if (empty($products_request)) {

                        return response()->json([
                            'error' => 'No se enviaron productos'
                        ], 400);
                    }
                }
            } else {

                $settlement_id = DB::table('Liquidacion')->insertGetId([
                    'id_departamento_servicio' => $department['id'],
                    'id_reserva_interna' => $reservation_id,
                    'id_estado' => 3,
                    'fecha_liquidacion' => now(),
                    'id_tipo_adicional' => isset($additional['id']) ? $additional['id'] : 0,
                    'nombre_departamento_servicio' => $department['name'],
                    'nombre_tipo_adicional' => isset($additional['name']) ? $additional['name'] : '',
                    'estado_solicitudes_terceros' => 0,
                    'user_creacion' => $user_id,
                    'fecha_creacion' => now(),
                    'user_ult_modif' => $user_id,
                    'fecha_ult_modif' => now()
                ], 'id_liquidacion');

                if ($settlement_id && $settlement_id > 0) {

                    $this->insertNewPlanRead($rese_anci, $rese_codi, $object_reservation, $products_request, array(), $user);

                    $this->save_products($products, $user_id, $settlement_id);

                    $this->updateReservation($reservation_id, $event_id, $settlement_id, $user_id);

                    return response()->json([
                        'id' => $settlement_id
                    ], 200);
                } else {

                    return response()->json([
                        'error' => 'No se almaceno la liquidación'
                    ], 400);
                }
            }
        } catch (Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

