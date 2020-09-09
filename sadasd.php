

                        <div class="=col-md-3">
                            <form method="POST">
                                <div class="customespec" > 
                                    <h4 class="text-info"><?php echo $row["name"] ?></h4>
                                    <h4 class="text-danger"><?php echo $row["price"]; ?></h4>
                                    <h4 class="text-danger"><?php echo $row["quantity"]; ?></h4>

                                    <input class="form-control" type ="text" name="quantitytoadd" value="1"/>
                                    <input type="hidden" name="hidden_id" value="<?php echo $row['id']; ?>"/>
                                    <input type="hidden" name="hidden_name" value="<?php echo $row['name']; ?>"/>
                                    <input type="hidden" name="hidden_price" value="<?php echo $row['price']; ?>"/>
                                    <input type="hidden" name="hidden_quantity" value="<?php echo $row['quantity']; ?>"/>
                                    <input type="submit" name="addtocart" style="margin-top: 5px;" class="btn btn-success" value="Add to Cart"/>
                                </div>
                            </form>
                        </div>






                        <?php
                            $companyid = $_SESSION['companyid'];
                            echo $companyid;
                            $result = $dbHandler->selectProductsForCompany($companyid);
                            while ($row = $result->fetch_assoc()) {
                                echo $row["name"];
                                echo "\n";
                                echo "<div class='=col-md-12'>";
                                echo"<form method='POST'>";
                                echo "<div class='customespec' >";
                                echo "<h4 class='text-info'>". $row['name'] . "</h4>";

                                echo "<input type='submit' name='addtocart' style='margin-top: 5px;' class='btn btn-success' value='Add to Cart'/>";
                                echo"</div>";
                                echo"</form>";
                                echo"</div>";
                            }
                        ?>