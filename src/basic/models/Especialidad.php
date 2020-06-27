<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
/**
 * This is the model class for table "especialidad".
 *
 * @property int $id_especialidad
 * @property string $nombre
 * @property string|null $detalle
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int $updated_at
 *
 * @property Medico[] $medicos
 */
class Especialidad extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'especialidad';
    }

    public function behaviors()
    {
        //$behaviors=parent::behaviors();
        return [
            BlameableBehavior::className(),
            TimestampBehavior::className(),
        ];


    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['nombre'], 'string', 'max' => 250],
            [['detalle'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_especialidad' => 'Id Especialidad',
            'nombre' => 'Nombre',
            'detalle' => 'Detalle',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Medicos]].
     *
     * @return \yii\db\ActiveQuery|MedicoQuery
     */
    public function getMedicos()
    {
        return $this->hasMany(Medico::className(), ['especialidad_id' => 'id_especialidad']);
    }

    /**
     * {@inheritdoc}
     * @return EspecialidadQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EspecialidadQuery(get_called_class());
    }
}
