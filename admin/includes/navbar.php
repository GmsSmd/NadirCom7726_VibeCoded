<div id='cssmenu'>
	<ul>
		<li><a href='summary.php'><span>Summary</span></a>
		    <ul>
				<li><a href='dailyactivity.php'><span>Daily Activity</span></a></li>
				<li><a href='oldactivity.php'><span>Old Activity</span></a></li>
			</ul>
		</li>
		<li><a href='#'><span>Sale & Purchase</span></a>
			<ul>
				<li><a href='lifting.php'><span>Purchases</span></a></li>
				<li><a href='dosales.php?name=DO'><span>Sales</span></a></li>
				<li><a href='mfsupload.php'><span>Jazz MFS</span></a>
				<!-- <li><a href='do.php?name=DO'><span>Sales Old</span></a></li> -->
					<ul>
						<li><a href='mfsupload.php'><span>Sheet Upload</span></a></li>
						<li><a href='domfs.php?name=DO'><span>Manual Entry</span></a></li>
						<li><a href='mfsupload_iq.php'><span>Initiator Query</span></a></li>
					</ul>
				</li>
			</ul>
		</li>	
		<li class='active has-sub'><a href='#'><span>Payments</span></a>
			<ul>
				<li><a href='dodues.php?name=DO'><span>DO Advance</span></a></li>
				<li><a href='#'><span>Comission</span></a>
						<ul>
							<li><a href='getcomission.php'><span>Receive Comission</span></a></li>
							<li><a href='paycomission.php?name=do'><span>Pay Comission</span></a></li>
						</ul>
				</li>
				<li><a href='companypayment.php?name=<?php echo $parentCompany?>'><span>Credit Clearance</span></a></li>
				<li><a href='addtax.php'><span>Pay Tax</span></a></li>
			</ul>
		</li>
		<li><a href='#'><span>Salary & Expenses</span></a>
					<ul>
			            <li><a href='expenses.php'><span>Daily Expenses</span></a></li>
					    
<?php
if($currentUserType=='Admin' OR $currentUserType=='Manager')
{
?>
					    <li><a href='#'><span>Salary</span></a>
					        <ul>
							<li><a href='currentsalary.php'><span>Current Salary</span></a></li>
							<li><a href='paysalary.php'><span>Pay Salary</span></a></li>
							<li><a href='salarydeduction.php'><span>Salary Deduction</span></a></li>
					        </ul>
					    </li>
<?php
}
?>
					    <li><a href='expensesfix.php'><span>Fixed Expenses</span></a></li>
					</ul>
					
		</li>
		<li class='active has-sub'><a href='#'><span>Manage</span></a>
			<ul>
				<li><a href='addusers.php'><span>Users</span></a></li>
				<li><a href='#'><span>HR Management</span></a>
				    <ul>
				        <?php
                        if($currentUserType=='Admin')
                        {
                        ?>
						<li><a href='addemp.php'><span>Employees</span></a></li>
						<?php
                        }
                        ?>
						<li><a href='changeemporder.php'><span>Change Emp Order</span></a></li>
						<li><a href='changeempvisibility.php'><span>Emp Show/Hide</span></a></li>
						<li><a href='addws.php'><span>WholeSeller</span></a></li>
						<li><a href='addrt.php'><span>Retailer</span></a></li>
					</ul>
				</li>
				<li><a href='#'><span>Products</span></a>
				    <ul>
						<li><a href='addproduct.php'><span>Products</span></a></li>
						<li><a href='addproducttypes.php'><span>Add Sub-Type</span></a></li>
						<li><a href='markproducttypes.php'><span>Mark Active</span></a></li>
						<li><a href='setrate.php?name=Card'><span>Set Rates</span></a></li>
					</ul>
				</li>
				<li><a href='addcompany.php'><span>Company</span></a></li>
			</ul>
		</li>
		<li class='active has-sub'><a href='#'><span>Reports</span></a>
			<ul>			
				<li><a href='stock.php?for=SIM'><span>Stock</span></a></li>
				<li><a href='#'><span>Summary</span></a>
					<ul>
						<li><a href='purchasesummary.php?for=Otar'><span>Purchase Summary</span></a></li>
						<li><a href='salesummary.php?for=Otar'><span>Sale Summary</span></a></li>
						<li><a href='paymentsummary.php'><span>Payment Summary</span></a></li>
						<li><a href='receiptsummary.php'><span>Receipt Summary</span></a></li>
					</ul>
				</li>
				<li><a href='expensereport.php'><span>Expense Report</span></a></li>
				<li><a href='#'><span>Bank Statement</span></a>
					<ul>
						<li><a href='bankstatement.php?for=<?php echo $defaultBankName?>'><span>Summary</span></a></li>
						<li><a href='bankstatementdowisetoday.php?for=<?php echo $defaultBankName?>'><span>DO Wise (Today)</span></a></li>
						<li><a href='bankstatementdowisefull.php?for=<?php echo $defaultBankName?>'><span>DO Wise (Monthly)</span></a></li>
					</ul>
				</li>
				<li><a href='#'><span>MFS Entries</span></a>
					<ul>
						<li><a href='mfstransactions.php'><span>MFS Transection</span></a></li>
						<li><a href='mfstransactions_iq.php'><span>Initiator Query</span></a></li>
					</ul>
				</li>
			</ul>
		</li>
		<li class='active has-sub'><a href='#'><span>Receivable</span></a>
			<ul>
			    <li><a href='#'><span>Summary</span></a>
					<ul>
					<li><a href='salereceivables.php'><span>Sales Only</span></a></li>
					<li><a href='allreceivables.php'><span>Combined</span></a></li>
					</ul>
				</li>
				<li><a href='#'><span>Category</span></a>
					<ul>
						<li><a href='rptlmc.php'><span>LMC</span></a></li>
						<li><a href='rptcard.php'><span>Card</span></a></li>
						<li><a href='rptmobile.php'><span>Mobile</span></a></li>
						<li><a href='rptsim.php'><span>SIM</span></a></li>
						<li><a href='rptdodues.php'><span>DO Advance</span></a></li>
					</ul>
					<li><a href='dorecord.php?name=DO'><span>Old Record</span></a></li>
				</li>
			</ul>
		</li>
		<li class='active has-sub'><a href='#'><span>Starting</span></a>
			<ul>
				<li><a href='investment.php'><span>Invest WithDraw</span></a></li>
				<li><a href='salary_adjust.php'><span>Salary Adjust</span></a></li>
				<li><a href='addtarget.php?name=Franchise'><span>Targets</span></a></li>
				<li><a href='monthclosing.php'><span>Monthly Closing</span></a></li>
				<li><a href='initialoc.php?name=Franchise'><span>Initial OC</span></a></li>
			</ul>
		</li>
		
		<li style="float:left">
			<h3> <?php echo $childOrganization?></h3>
		</li>
				<!-- <li><iframe src="http://free.timeanddate.com/clock/i68ku930/n758/fn7/fs10/fcfff/tct/pct/tt0/tw1/tm1/th2/tb4" frameborder="0" width="93" height="30" allowTransparency="true"></iframe></li>
				-->

		<li style="float:right"><a href="../logout.php"> Log Out (<?php echo $currentActiveUser; ?>)</a></li>
	</ul>
	
</div>



