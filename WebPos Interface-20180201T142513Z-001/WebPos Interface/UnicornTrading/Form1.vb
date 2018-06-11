Option Strict Off
Imports System.IO
Imports System.Text
Imports System.Text.RegularExpressions
Imports FPAX_TAN2000

Public Class Form1

    Dim mypr As New FPAX_TAN200
    Dim filepath As String
    Dim QuoteNR As String
    Dim sett As String
    Dim cpset As Integer
    Dim s As Integer
    Dim istat As String

    Dim tendamt As String
    Dim taxcode As String
    Dim product As String
    Dim price As String
    Dim quantity As String
    Dim disc, desc2 As String
    Dim nod As Integer
    Dim PAYT As String
    Dim tend As Decimal
    Dim chk As Integer
    Dim tot As Decimal
    Dim cashier As String
    Dim trans As String

    Dim rg1 As New Regex("([0-9]+\.[0-9]{2})")
    Dim eftpath As String = "C:\Receipts\Eftslip.txt"


    Private Sub Form1_Load(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MyBase.Load
        If My.Computer.FileSystem.DirectoryExists("C:\Receipts") = False Then
            My.Computer.FileSystem.CreateDirectory("C:\Receipts")
            My.Computer.FileSystem.CreateDirectory("C:\Receipts\Backup")
            System.IO.File.Create("C:\Receipts\config.ini").Close()
            System.IO.File.Create("C:\Receipts\log.txt").Close()
            Dim ry As New StreamWriter("C:\Receipts\config.ini")
            ry.Write("COMPORT 1")
            ry.WriteLine()
            ry.Write("PATH C:\Receipts\receipt.txt")
            ry.Close()
            MessageBox.Show("Restarting For Changes to take effect", "Initialisation", System.Windows.Forms.MessageBoxButtons.OK, System.Windows.Forms.MessageBoxIcon.Information)
            MessageBox.Show("ComPort Set to Com1, Change if different", "Initialisation", System.Windows.Forms.MessageBoxButtons.OK, System.Windows.Forms.MessageBoxIcon.Information)
            Me.Close()
            Application.Restart()

        Else


            Dim fer As String

            For Each line As String In File.ReadAllLines("C:\Receipts\config.ini")
                fer = line.ToString
                ' MsgBox(fer)
                If fer.StartsWith("COMPORT") Then

                    sett = line.Substring(7, line.Length - 7)
                    sett = sett.Trim
                    cpset = Integer.Parse(sett)
                    ' MsgBox(cpset)
                ElseIf fer.StartsWith("PATH") Then
                    sett = line.Substring(4, line.Length - 4)
                    sett = sett.Trim
                    filepath = sett
                    ' MsgBox(filepath)
                End If
            Next
            Timer1.Start()
        End If
    End Sub



    'Receipt Procedure Commands

    Public Sub seektyp()

        For Each line As String In File.ReadAllLines(filepath)

            If line.Contains("</ISTATUS>") Then
                line = line.Substring(line.IndexOf(">") + 1, line.LastIndexOf("<") - (line.IndexOf(">") + 1))
                line = line.Trim
                istat = line
                '   MsgBox(istat)
                Exit For


            End If


        Next



        If istat.Equals("01") Then

            printreceiptproc()
            Exit Sub

        ElseIf istat.Equals("02") Then

        ElseIf istat.Equals("05") Then

        End If





    End Sub




    Public Sub spitish()

        inianconec()
        opnonfis()

        For Each lin As String In File.ReadAllLines(filepath)

            If lin.Length > 42 Then
                lin = lin.Substring(0, 42)
            End If
            lin = lin.Trim
            mypr.CMD_42_0_0(lin)

        Next

        clsnonfis()
        discon()
        My.Computer.FileSystem.DeleteFile(filepath)
        Timer1.Start()

    End Sub
  
    Public Sub printreceiptproc()

        inianconec()
        opfisc()
        mypr.CMD_92_0_0("1")

        For Each line As String In File.ReadAllLines(filepath)

            If line.Contains("</INUM>") Then
                line = line.Substring(line.IndexOf(">") + 1, line.LastIndexOf("<") - (line.IndexOf(">") + 1))
                line = line.Trim
                If line.Length > 36 Then
                    line = line.Substring(0, 36)

                End If
                'MsgBox("</INUM> " + line)
                mypr.CMD_54_0_0(line)

            ElseIf line.Contains("</IPAYER>") Then
                line = line.Substring(line.IndexOf(">") + 1, line.LastIndexOf("<") - (line.IndexOf(">") + 1))
                line = line.Trim
                'MsgBox("</IPAYER>" + line)
                If line.Length > 36 Then
                    line = line.Substring(0, 36)

                End If
                mypr.CMD_54_0_0(line)
            ElseIf line.Contains("</IPVAT>") Then
                line = line.Substring(line.IndexOf(">") + 1, line.LastIndexOf("<") - (line.IndexOf(">") + 1))
                line = line.Trim
                'MsgBox("</IPVAT>" + line)
                If line.Length > 36 Then
                    line = line.Substring(0, 36)

                End If
                mypr.CMD_54_0_0(line)
            ElseIf line.Contains("</IPTEL>") Then
                line = line.Substring(line.IndexOf(">") + 1, line.LastIndexOf("<") - (line.IndexOf(">") + 1))
                line = line.Trim
                'MsgBox("</IPTEL> " + line)
                If line.Length > 36 Then
                    line = line.Substring(0, 36)

                End If
                mypr.CMD_54_0_0(line)

            ElseIf line.Contains("</IISSUER>") Then
                line = line.Substring(line.IndexOf(">") + 1, line.LastIndexOf("<") - (line.IndexOf(">") + 1))
                line = line.Trim
                'MsgBox("</IISSUER>" + line)
                If line.Length > 36 Then
                    line = line.Substring(0, 36)

                End If
                mypr.CMD_54_0_0(line)
                mypr.CMD_92_0_0("3")
            ElseIf line.Contains("</ITEMCODE>") Then
                line = line.Substring(line.IndexOf(">") + 1, line.LastIndexOf("<") - (line.IndexOf(">") + 1))


                If line.Length > 36 Then
                    line = line.Substring(0, 36)

                End If
                line = line.Trim

                desc2 = line
                'MsgBox("</ITEMCODE>" + desc2)
                mypr.CMD_54_0_0(desc2)
            ElseIf line.Contains("</ITEMNAME1>") Then
                line = line.Substring(line.IndexOf(">") + 1, line.LastIndexOf("<") - (line.IndexOf(">") + 1))
                line = line.Trim

                If line.Length > 36 Then
                    line = line.Substring(0, 36)

                End If

                product = line.Trim

                'MsgBox(product)

            ElseIf line.Contains("</QTY>") Then
                line = line.Substring(line.IndexOf(">") + 1, line.LastIndexOf("<") - (line.IndexOf(">") + 1))
                line = line.Trim
                quantity = line.Trim
                'MsgBox("</QTY>" + quantity)

            ElseIf line.Contains("</PRICE>") Then
                line = line.Substring(line.IndexOf(">") + 1, line.LastIndexOf("<") - (line.IndexOf(">") + 1))
                line = line.Trim

                line = line.Replace("$", "")
                line = line.Replace(",", "")

                price = line.Trim
                'MsgBox("</PRICE>" + price)

            ElseIf line.Contains("</TAXR>") Then
                line = line.Substring(line.IndexOf(">") + 1, line.LastIndexOf("<") - (line.IndexOf(">") + 1))
                line = line.Trim

                If line.Equals("0.15") Then
                    taxcode = "A"
                Else
                    taxcode = "B"
                End If
                'MsgBox("</TAXR>" + taxcode)

                sell()

            ElseIf line.Contains("</IAMT>") Then
                line = line.Substring(line.IndexOf(">") + 1, line.LastIndexOf("<") - (line.IndexOf(">") + 1))
                line = line.Trim
                line = line.Replace("$", "")
                line = line.Replace(",", "")
                line = FormatNumber(line, 2)
                tendamt = line
                'MsgBox("</IAMT>" + tendamt)

            ElseIf line.Contains("</AMOUNTTENDERED>") Then
                line = line.Substring(line.IndexOf(">") + 1, line.LastIndexOf("<") - (line.IndexOf(">") + 1))
                line = line.Trim
                line = line.Replace("$", "")
                line = line.Replace(",", "")
                line = FormatNumber(line, 2)
                tendamt = line

                'MsgBox("</AMOUNTTENDERED>" + tendamt)

            End If


        Next

        PAYT = "P"
        subt()
        tender()
        clfisc()
        discon()



    End Sub


  
    'Context Menu Procedure
    Private Sub ZReportToolStripMenuItem_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles ZReportToolStripMenuItem.Click
        inianconec()
        Dim N As String, A As String, Closure As String, TotA As String, totB As String, TotC As String, TotD As String, TotE As String, TotF As String
        'lResult = ciPrinter.CMD_69_0_0(xOption, N, A, Closure, TotA, totB, TotC, TotD, TotE, TotF)
        s = mypr.CMD_69_0_0(0, N, A, Closure, TotA, totB, TotC, TotD, TotE, TotF)

        If s <> 0 Then
            MsgBox("error: " + Str(s))
        End If

        If My.Computer.FileSystem.DirectoryExists("C:\Receipts") And My.Computer.FileSystem.FileExists("C:\Receipts\log.txt") Then
            Dim ry As New StreamWriter("C:\Receipts\log.txt", True)
            ry.Write("--------------------------")
            ry.Write("--------------------------")
            ry.WriteLine(" ")
            ry.Close()
        Else
            MsgBox("log error : Contact Provider")
            Me.Close()
        End If
        discon()
    End Sub
    Private Sub XReportToolStripMenuItem_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles XReportToolStripMenuItem.Click
        inianconec()
        Dim N As String, A As String, Closure As String, TotA As String, totB As String, TotC As String, TotD As String, TotE As String, TotF As String
        s = mypr.CMD_69_0_0(2, N, A, Closure, TotA, totB, TotC, TotD, TotE, TotF)
        If s <> 0 Then
            MsgBox("error: " + Str(s))
        End If
        discon()
    End Sub
    Private Sub CancelReceiptToolStripMenuItem_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles CancelReceiptToolStripMenuItem.Click
        inianconec()
        s = mypr.CMD_60_0_0()
        If s <> 0 Then
            MsgBox("Failed to cancel fiscal receipt: " + Str(s))
        End If
        discon()
    End Sub
    Private Sub ExitToolStripMenuItem_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles ExitToolStripMenuItem.Click
        Application.Exit()


    End Sub



    'FISCAL PRINTER COMMANDS
    Public Sub inianconec()

        s = mypr.INIT_MY_FP(cpset, 115200, False, False, 2000)

        If s <> 0 Then
            MsgBox("Initialisation Error", , "")
        End If

        s = mypr.CONNECT_TO_PRINTER()

        If s <> 0 Then

            MsgBox("CONNECTION ERROR !", , "")
            Application.Exit()
            Me.Close()
        Else
            'MsgBox("zvafaya")
        End If
    End Sub
    Public Sub discon()
        s = mypr.CLOSE_CONNECTION()

        If s <> 0 Then
            MsgBox("failed to close")
        Else
            ' MsgBox("goodbye")
        End If
    End Sub
    Public Sub opfisc()
        Dim sRecCnt As String
        Dim sGlobRecCnt As String

        s = mypr.CMD_48_0_0("1", "0000", "1", sRecCnt, sGlobRecCnt)
        If s <> 0 Then
            MsgBox("Failed fiscal receipt: " + Str(s))
        End If
    End Sub
    Public Sub clfisc()
        Dim sRecCnt As String
        Dim sGlobRecCnt As String

        s = mypr.CMD_56_0_0(sRecCnt, sGlobRecCnt)
        If s <> 0 Then
            MsgBox("Failed to close fiscal receipt: " + Str(s))
        Else
            chk = 1
        End If

        If chk = 1 Then
            Dim j As String
            j = Date.Now.ToString
            j = j.Replace("/", "-")
            j = j.Replace(":", "_")
            Dim bh As String = "C:\invoices\" & j & ".txt"
            '  MsgBox(bh)

            My.Computer.FileSystem.CopyFile(filepath, "C:\Receipts\Backup\" & j & ".txt")

            My.Computer.FileSystem.DeleteFile(filepath)

            If My.Computer.FileSystem.DirectoryExists("C:\Receipts") And My.Computer.FileSystem.FileExists("C:\Receipts\log.txt") Then
                Dim ry As New StreamWriter("C:\Receipts\log.txt", True)
                ry.Write(bh)
                ry.WriteLine(" ")
                '    ry.WriteLine(" ")
                ry.Close()
            Else
                MsgBox("log error : Contact Provider")
                Me.Close()
            End If
        Else

        End If

        tend = New Decimal
        tot = New Decimal
        Timer1.Start()

    End Sub
    Public Sub sell()
        s = mypr.CMD_49_0_9(product, desc2, taxcode, price, quantity, " ")
        If s <> 0 Then
            MsgBox("Failed to sell item: " + Str(s))
        End If
    End Sub
    Public Sub subt()
        Dim sSubTotal As String
        Dim sTaxA As String
        Dim sTaxB As String
        Dim sTaxC As String
        Dim sTaxD As String
        Dim sTaxE As String
        Dim sTaxF As String

        s = mypr.CMD_51_0_2("1", "1", "-" & disc, sSubTotal, sTaxA, sTaxB, sTaxC, sTaxD, sTaxE, sTaxF)

        If s <> 0 Then
            MsgBox("Failed to do subtotal: " + Str(s))
        End If
    End Sub
    Public Sub tender()
        Dim sPaidCode As String
        Dim sAmount As String
        'remove discount
        ' tend = (tend - (tend * (disc / 100)))
        'tend = tend + (tend * 0.15)
        'tend = Math.Round(tend, 2)
        'MsgBox(tendamt)
        'MsgBox(PAYT)
        s = mypr.CMD_53_0_0(PAYT, tendamt, sPaidCode, sAmount)
        '''''''lResult = ciPrinter.CMD_53_0_0("N", "2.00", sPaidCode, sAmount)
        '''''''lResult = ciPrinter.CMD_53_0_0("P", "2.00", sPaidCode, sAmount)
        If s <> 0 Then
            MsgBox("Failed to do total: " + Str(s))
        End If
    End Sub
    Public Sub opnonfis()
        Dim sRecCnt As String
        Dim sGlobRecCnt As String

        s = mypr.CMD_38_0_0(sRecCnt, sGlobRecCnt)
        If s <> 0 Then
            MsgBox("Failed to open non fiscal receipt: " + Str(s))
        End If
    End Sub
    Public Sub clsnonfis()
        Dim sRecCnt As String
        Dim sGlobRecCnt As String

        mypr.CMD_39_0_0(sRecCnt, sGlobRecCnt)
        If s <> 0 Then
            MsgBox("Failed to close non fiscal receipt: " + Str(s))
        End If
        'resets tend

    End Sub

    Private Sub Timer1_Tick(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Timer1.Tick
        If My.Computer.FileSystem.FileExists(filepath) Then
            Timer1.Stop()
            'checks receipt. Edit this for layout
            seektyp()

        ElseIf My.Computer.FileSystem.FileExists(eftpath) Then
            Timer1.Stop()
            credprocedure()

        End If
    End Sub

    Public Sub credprocedure()

        Dim responsetext, retrievalref, TerminalID, CardProdName, Cardnumber, datez, postransaction, method, defaultcard, responsecode, status, goods, cashback, total As String
        Dim cntr As Integer = 0
        'Dim subt As String
        Dim ttl As String

        Try
            inianconec()
            opnonfis()
            '  Timer1.Start()
        Catch ex As Exception
            Exit Sub
        End Try


        mypr.CMD_92_0_0("3")
        mypr.CMD_42_0_0("MERCHANT COPY")
        mypr.CMD_92_0_0("3")

        Dim Inumber As String
        Inumber = My.Computer.FileSystem.ReadAllText(eftpath)
        Inumber = Inumber.Substring(Inumber.LastIndexOf(">") + 1, Inumber.Length - (Inumber.LastIndexOf(">") + 1))

        Dim Receipt() As String

        Receipt = My.Computer.FileSystem.ReadAllText(eftpath).Split("<")

        For Each line As String In Receipt

            If line.Contains("Transaction Account") Then
                ' MsgBox(line)
                retrievalref = line.Substring(line.IndexOf("RetrievalRefNr=") + 16, line.IndexOf("TerminalId=") - 2 - (line.IndexOf("RetrievalRefNr=") + 16))
                ' MsgBox(retrievalref)
                mypr.CMD_42_0_0("Retrieval Ref ID : " + retrievalref)
                Cardnumber = line.Substring(line.IndexOf("CardNumber=") + 12, line.IndexOf("CardProductName=") - 2 - (line.IndexOf("CardNumber=") + 12))

                ' MsgBox(Cardnumber)

                mypr.CMD_42_0_0("Card Number      : " + Cardnumber)

                Try
                    CardProdName = line.Substring(line.IndexOf("CardProductName=") + 17, line.IndexOf("CurrencyCode=") - 2 - (line.IndexOf("CardProductName=") + 17))
                Catch ex As Exception

                End Try
                Try
                    CardProdName = line.Substring(line.IndexOf("CardProductName=") + 17, line.IndexOf("CardSequenceNumber=") - 2 - (line.IndexOf("CardProductName=") + 17))
                Catch ex As Exception

                End Try

                Try
                    TerminalID = line.Substring(line.IndexOf("TerminalId=") + 12, line.IndexOf("TransactionAmount=") - 2 - (line.IndexOf("TerminalId=") + 12))
                    '    mypr.CMD_42_0_0("TerminalID  : " + TerminalID)
                    ' MsgBox(TerminalID)
                Catch ex As Exception

                End Try

                Try
                    TerminalID = line.Substring(line.IndexOf("TerminalId=") + 12, line.IndexOf("Track2=") - 2 - (line.IndexOf("TerminalId=") + 12))
                    '     mypr.CMD_42_0_0("TerminalID  : " + TerminalID)
                    ' MsgBox(TerminalID)
                Catch ex As Exception

                End Try


                mypr.CMD_42_0_0("TerminalID       : " + TerminalID)

                Try
                    total = line.Substring(line.IndexOf("TransactionAmount=") + 19, line.IndexOf("TransactionId=") - 2 - (line.IndexOf("TransactionAmount=") + 19)).Trim
                    total = (CDec(total) / 100).ToString
                    ' MsgBox(TerminalID)
                Catch ex As Exception

                End Try
                datez = Date.Now.ToShortDateString + " " + Date.Now.ToLongTimeString
                'MsgBox(datez)
                mypr.CMD_42_0_0("Date             : " + datez)
                postransaction = "Inv#dummy"
                mypr.CMD_42_0_0("Invoice Number   : " + Inumber)
                method = ""
                mypr.CMD_42_0_0("Method           : " + CardProdName)
                'defaultcard = line.Substring(line.IndexOf("RetrievalRefNr=") + 16, line.IndexOf("TerminalId=") - 2 - (line.IndexOf("RetrievalRefNr=") + 17))
                responsecode = line.Substring(line.LastIndexOf("ResponseCode=") + 14, line.IndexOf("RetrievalRefNr=") - 2 - (line.LastIndexOf("ResponseCode=") + 14))
                '  MsgBox(responsecode)


                If (responsecode.Trim.Equals("91")) Then
                    responsetext = "Issuer or switch inoperative"
                ElseIf (responsecode.Trim().Equals("00")) Then
                    responsetext = "Approved or completed successfully"
                ElseIf (responsecode.Trim().Equals("01")) Then
                    responsetext = "Refer to card issuer"
                ElseIf (responsecode.Trim().Equals("02")) Then
                    responsetext = "Refer to card issuer, special condition"
                End If
                mypr.CMD_42_0_0("Response Code    : " + responsecode)
                mypr.CMD_42_0_0(responsetext)
                '   goods = line.Substring("Goods        dummyamount")
                mypr.CMD_42_0_0("Goods        $" + total)
                mypr.CMD_42_0_0("Cash back    0")
                mypr.CMD_42_0_0("Total        $" + total)
                mypr.CMD_42_0_0(" ")
                mypr.CMD_42_0_0(" ")
                mypr.CMD_42_0_0(" ")
                mypr.CMD_42_0_0(" ")

                mypr.CMD_42_0_0("Customer sign____________________________")

                'status = line.Substring(line.IndexOf("RetrievalRefNr=") + 16, line.IndexOf("TerminalId=") - 2 - (line.IndexOf("RetrievalRefNr=") + 17))
                'goods = line.Substring(line.IndexOf("RetrievalRefNr=") + 16, line.IndexOf("TerminalId=") - 2 - (line.IndexOf("RetrievalRefNr=") + 17))
                'cashback = line.Substring(line.IndexOf("RetrievalRefNr=") + 16, line.IndexOf("TerminalId=") - 2 - (line.IndexOf("RetrievalRefNr=") + 17))
                'total = line.Substring(line.IndexOf("RetrievalRefNr=") + 16, line.IndexOf("TerminalId=") - 2 - (line.IndexOf("RetrievalRefNr=") + 17))

            End If


        Next

        'For Each dline As String In File.ReadAllLines(eftpath)
        '    dline = dline.Trim

        '    If (dline.Length > 42) Then
        '        dline = dline.Substring(0, 42)
        '        mypr.CMD_42_0_0(dline)
        '    Else
        '        mypr.CMD_42_0_0(dline)
        '    End If



        'Next
        mypr.CMD_92_0_0("3")
        clsnonfis()
        discon()



        'PRINT CUSTOMER SECTION


        Try
            inianconec()
            opnonfis()
        Catch ex As Exception
            Timer1.Start()
            Exit Sub
        End Try

        mypr.CMD_92_0_0("3")
        mypr.CMD_42_0_0("CUSTOMER COPY")
        mypr.CMD_92_0_0("3")

        ' Dim Receipt() As String

        Receipt = My.Computer.FileSystem.ReadAllText(eftpath).Split("<")

        For Each line As String In Receipt

            If line.Contains("Transaction Account") Then
                ' MsgBox(line)
                retrievalref = line.Substring(line.IndexOf("RetrievalRefNr=") + 16, line.IndexOf("TerminalId=") - 2 - (line.IndexOf("RetrievalRefNr=") + 16))
                ' MsgBox(retrievalref)
                mypr.CMD_42_0_0("Retrieval Ref ID : " + retrievalref)
                Cardnumber = line.Substring(line.IndexOf("CardNumber=") + 12, line.IndexOf("CardProductName=") - 2 - (line.IndexOf("CardNumber=") + 12))

                ' MsgBox(Cardnumber)

                mypr.CMD_42_0_0("Card Number      : " + Cardnumber)

                Try
                    CardProdName = line.Substring(line.IndexOf("CardProductName=") + 17, line.IndexOf("CurrencyCode=") - 2 - (line.IndexOf("CardProductName=") + 17))
                Catch ex As Exception

                End Try
                Try
                    CardProdName = line.Substring(line.IndexOf("CardProductName=") + 17, line.IndexOf("CardSequenceNumber=") - 2 - (line.IndexOf("CardProductName=") + 17))
                Catch ex As Exception

                End Try

                Try
                    TerminalID = line.Substring(line.IndexOf("TerminalId=") + 12, line.IndexOf("TransactionAmount=") - 2 - (line.IndexOf("TerminalId=") + 12))
                    '    mypr.CMD_42_0_0("TerminalID  : " + TerminalID)
                    ' MsgBox(TerminalID)
                Catch ex As Exception

                End Try

                Try
                    TerminalID = line.Substring(line.IndexOf("TerminalId=") + 12, line.IndexOf("Track2=") - 2 - (line.IndexOf("TerminalId=") + 12))
                    '     mypr.CMD_42_0_0("TerminalID  : " + TerminalID)
                    ' MsgBox(TerminalID)
                Catch ex As Exception

                End Try


                mypr.CMD_42_0_0("TerminalID       : " + TerminalID)

                Try
                    total = line.Substring(line.IndexOf("TransactionAmount=") + 19, line.IndexOf("TransactionId=") - 2 - (line.IndexOf("TransactionAmount=") + 19)).Trim
                    total = (CDec(total) / 100).ToString
                    ' MsgBox(TerminalID)
                Catch ex As Exception

                End Try
                datez = Date.Now.ToShortDateString + " " + Date.Now.ToLongTimeString
                'MsgBox(datez)
                mypr.CMD_42_0_0("Date             : " + datez)
                postransaction = "Inv#dummy"
                mypr.CMD_42_0_0("Invoice Number   : " + Inumber)
                method = ""
                mypr.CMD_42_0_0("Method           : " + CardProdName)
                'defaultcard = line.Substring(line.IndexOf("RetrievalRefNr=") + 16, line.IndexOf("TerminalId=") - 2 - (line.IndexOf("RetrievalRefNr=") + 17))
                responsecode = line.Substring(line.LastIndexOf("ResponseCode=") + 14, line.IndexOf("RetrievalRefNr=") - 2 - (line.LastIndexOf("ResponseCode=") + 14))
                '  MsgBox(responsecode)


                If (responsecode.Trim.Equals("91")) Then
                    responsetext = "Issuer or switch inoperative"
                ElseIf (responsecode.Trim().Equals("00")) Then
                    responsetext = "Approved or completed successfully"
                ElseIf (responsecode.Trim().Equals("01")) Then
                    responsetext = "Refer to card issuer"
                ElseIf (responsecode.Trim().Equals("02")) Then
                    responsetext = "Refer to card issuer, special condition"
                End If
                mypr.CMD_42_0_0("Response Code    : " + responsecode)
                mypr.CMD_42_0_0(responsetext)
                '   goods = line.Substring("Goods        dummyamount")
                mypr.CMD_42_0_0("Goods        $" + total)
                mypr.CMD_42_0_0("Cash back    0")
                mypr.CMD_42_0_0("Total        $" + total)

                'status = line.Substring(line.IndexOf("RetrievalRefNr=") + 16, line.IndexOf("TerminalId=") - 2 - (line.IndexOf("RetrievalRefNr=") + 17))
                'goods = line.Substring(line.IndexOf("RetrievalRefNr=") + 16, line.IndexOf("TerminalId=") - 2 - (line.IndexOf("RetrievalRefNr=") + 17))
                'cashback = line.Substring(line.IndexOf("RetrievalRefNr=") + 16, line.IndexOf("TerminalId=") - 2 - (line.IndexOf("RetrievalRefNr=") + 17))
                'total = line.Substring(line.IndexOf("RetrievalRefNr=") + 16, line.IndexOf("TerminalId=") - 2 - (line.IndexOf("RetrievalRefNr=") + 17))

            End If


        Next

        'For Each dline As String In File.ReadAllLines(eftpath)
        '    dline = dline.Trim

        '    If (dline.Length > 42) Then
        '        dline = dline.Substring(0, 42)
        '        mypr.CMD_42_0_0(dline)
        '    Else
        '        mypr.CMD_42_0_0(dline)
        '    End If



        'Next
        mypr.CMD_92_0_0("3")
        clsnonfis()
        discon()

        My.Computer.FileSystem.DeleteFile(eftpath)
        Timer1.Start()
        Exit Sub

    End Sub


   
End Class
