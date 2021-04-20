<?php

namespace App\Domain\Catalog\Import;


use Maatwebsite\Excel\Concerns\ToModel;

class ProductsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Model
        $establishmentModel = "App\Domain\Establishment\Entity\Establishment";
        $productModel = "App\Domain\Catalog\Entity\Product";
        $thumbnailModel = "App\Domain\Thumbnail\Thumbnail";
        $variantModel = "App\Domain\Catalog\Entity\Variant";
        $attributeModel = "App\Domain\Catalog\Entity\Attribute";
        $productVariantModel = "App\Domain\Catalog\Entity\ProductVariant";

        /*
         * $row[0] => Product Name
         * $row[1] => Product Name
         * $row[2] =>  Product description
         * $row[3] =>  Thumbnail path
         * $row[4] => Thumbnail order
         * $row[5] => Product price
         * $row[6] => Product category
         * $row[7] => Variant name
         * $row[8] => Attribute name
         * $row[9] => PriceImpact
         */

        // Global variables
        global $establishmentId;
        global $establishment;
        global $productId;
        global $variantId;
        global $thumbnailId;
        global $attributeId;


        // Find establishment
        $establishment = $this->findEntity($establishmentModel, [
            'slug' => $row[0]
        ]);
        $establishmentId = $establishment->id;


        if(! is_null($row[1])) {
            /*
             * Search if the product exists
             */
            $product = $this->findEntity($productModel, [
                'name' => $row[1],
                'description' => $row[2],
                'price' => $row[5],
                'isActive' => 1,
                'establishment_id' => $establishment->id
            ]);
            if(!is_null($product))
            {
                $productId = $product->id;
            } else {
                /*
                 * Create product
                 */
                $product = $this->addEntity($productModel, [
                    'name' => $row[1],
                    'description' => $row[2],
                    'price' => $row[5],
                    'isActive' => 1,
                    'establishment_id' => $establishment->id
                ]);
                $productId = $product->id;
            }
        }

        if(!is_null($row[3])) {
            /*
             * Search if the thumbnail exists
             */
            $thumbnail = $this->findEntity($thumbnailModel, [
                'path' => $row[3],
                'order' => 0,
                'thumbnaible_id' => $productId,
                'thumbnaible_type' => "App\Domain\Catalog\Entity\Product",
            ]);

            if(! is_null($thumbnail))
            {
                $thumbnailId = $thumbnail->id;
            } else {
                /*
                * Create thumbnail and link it to the product
                */
                $thumbnail = $this->addEntity($thumbnailModel, [
                    'path' => $row[3],
                    'order' => $row[4],
                    'thumbnaible_id' => $productId,
                    'thumbnaible_type' => "App\Domain\Catalog\Entity\Product",
                ]);
                $thumbnailId = $thumbnail->id;
            }
        }

        if(!is_null($row[7])) {
            /*
             * Search if variant exists
             */
            $variant = $this->findEntity($variantModel, [
                'name' => $row[7],
                'establishment_id' => $establishmentId
            ]);

            if(! is_null($variant))
            {
                $variantId = $variant->id;
            } else {
                /*
                * Create variant
                */
                $variant = $this->addEntity($variantModel, [
                    'name' => $row[7],
                    'establishment_id' => $establishmentId,
                ]);
                $variantId = $variant->id;
            }
        }

        if(!is_null($row[8])) {
                /*
                * Search if attribute exist
                */
            $attribute = $this->findEntity($attributeModel, [
                'name' => $row[8],
                'variant_id' => $variantId,
            ]);

            if(! is_null($attribute))
            {
                $attributeId = $attribute->id;
            } else {
                /*
                * Create attribute
                */
                $attribute = $this->addEntity($attributeModel, [
                    'name' => $row[8],
                    'variant_id' => $variantId,
                ]);
                $attributeId = $attribute->id;
            }
        }

        /*
         * Create relationship variant/attribute -> product
         */
        if(!is_null($row[7]) || !is_null($row[8])) {
            $productVariant = $this->findEntity($productVariantModel, [
                'product_id' => $productId,
                'variant_id' => $variantId,
                'attribute_id' => $attributeId,
                'priceImpact' => $row[9],
            ]);

            if(! is_null($productVariant))
            {
                $productVariantId = $productVariant->id;
            } else {
                $productVariant = $this->addEntity($productVariantModel, [
                    'product_id' => $productId,
                    'variant_id' => $variantId,
                    'attribute_id' => $attributeId,
                    'priceImpact' => $row[9],
                ]);
                $productVariantId = $productVariant->id;
            }
        }

    }

    /*
     * Entity search function
     * @Params: Model: String (With namespace) / Column: Array
     * @return Collection
     */
    public function findEntity($model,$column)
    {
        return $model::where($column)
            ->first();
    }

    /*
     * Add entity function
     * @Params: Model: String (With namespace) / Data: Array
     * @return Array
     */
    public function addEntity($model, $data)
    {
        $entity = $model::create($data);
        $entity->save();
        return $entity;
    }

    /*
     * Find relationship between two models
     * @Params: Model: String (With namespace) / searchArray: Array
     * @return Collection
     */
    public function findRelation($model,$searchArray = [])
    {
        return $model::where($searchArray)
            ->first();
    }
}
